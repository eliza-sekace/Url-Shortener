<?php

namespace App\Controllers;

use App\Exceptions\ValidationException;
use App\Redirect;
use App\Repositories\RecordsRepository;
use App\Services\HashService;
use App\Validation\FormValidator;
use App\Views\View;
use Doctrine\DBAL\Driver\PDO\Exception;

class ShortenerController
{
    public function create(): View
    {
        return new View('create.html', [
            'errors' => $_SESSION['errors'] ?? [],
            'result' => $_SESSION['result'] ?? []
        ]);
    }

    public function store()
    {
        try {
            $validator = new FormValidator($_POST, [
                'url' => ['required', 'valid']
            ]);
            $validator->passes();

        } catch (ValidationException $exception) {
            $_SESSION['errors'] = $validator->getErrors();
            $_SESSION['inputs'] = $_POST;
            return new Redirect('/');
        }

        $repository = new RecordsRepository();
        $record = $repository->getByLongUrl($_POST['url']);

        if (!$record) {
            $service = new HashService();
            $hash = $service->createHash();
            $attributes = [
                'long_url' => $_POST['url'],
                'short_code' => $hash
            ];
            $record = $repository->store($attributes);
        }
        $_SESSION['result'] = $record;
        return new Redirect("/");
    }

    public function redirect($vars)
    {
        $repository = new RecordsRepository();
        $record = $repository->getByShortCode($vars['hash']);
        if (!$record) {
            throw new Exception("Shortened URL code does not appear to exist.");
        } else {
            return new Redirect($record->getLongUrl());
        }
    }
}


