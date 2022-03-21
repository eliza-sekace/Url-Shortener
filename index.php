<?php

use App\Redirect;
use App\Views\View;

require_once 'vendor/autoload.php';
session_start();
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\Controllers\ShortenerController', 'create']);
    $r->addRoute('POST', '/', ['App\Controllers\ShortenerController', 'store']);
    $r->addRoute('GET', '/{hash}', ['App\Controllers\ShortenerController', 'redirect']);


});
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1][0];
        $method = $routeInfo[1][1];
        $vars = $routeInfo[2] ?? [];

        $view = (new $handler)->$method($vars);

        $loader = new \Twig\Loader\FilesystemLoader('app/views');
        $twig = new \Twig\Environment($loader);

        if ($view instanceof View) {
            echo $twig->render($view->getPath(), $view->getVariables());
        }

        if ($view instanceof Redirect) {
            header('Location: ' . $view->getLocation());
            exit;
        }
        break;
}

if (isset($_SESSION['errors'])) {
    unset($_SESSION['errors']);
}

if (isset($_SESSION['result'])) {
    unset($_SESSION['result']);
}
