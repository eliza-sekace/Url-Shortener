<?php

namespace App\Validation;

use App\Exceptions\ValidationException;

class FormValidator
{
    private $data;
    private array $errors = [];
    private array $rules;

    public function __construct($data, array $rules = [])
    {
        $this->data = $data;
        $this->rules = $rules;
    }

    public function passes()
    {
        foreach ($this->rules as $key => $rules) {
            foreach ($rules as $rule) {
                $this->{'validate' . ucfirst($rule)}($key);
            }
        }
        if (count($this->errors) > 0) {
            throw new ValidationException();
        }
    }

    private function validateRequired(string $key): void
    {
        if (strlen(trim($this->data[$key])) === 0) {
            var_dump($this->data[$key] === 0);
            $this->errors[] = "No URL was supplied.";
        }
    }

    private function validateValid(string $key)
    {
        if (filter_var($this->data[$key], FILTER_VALIDATE_URL) == false) {
            $this->errors[] = "URL does not have a valid format.";
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

}