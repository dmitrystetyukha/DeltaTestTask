<?php

use App\Controller\InfographicController;
use Zaphyr\HttpMessage\ServerRequest;
use Zaphyr\Router\Router;

$_SERVER['DOCUMENT_ROOT'] = '/var/www/html';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$router = new Router();

try {
    $router->add('/infographic/get/{date}', ['GET'], [new InfographicController(), 'getAction']);
} catch (\Zaphyr\Router\Exceptions\RouteException $e) {
    dd($e);
}

try {
    $response = $router->handle(new ServerRequest($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']));
    header(sprintf('HTTP/1.1 %s %s', $response->getStatusCode(), $response->getReasonPhrase()));
    foreach ($response->getHeaders() as $name=>[$value]) {
        header(sprintf('%s: %s', $name, $value));
    }
    echo $response->getBody();
    die();
} catch (Zaphyr\Router\Exceptions\NotFoundException|\Zaphyr\Router\Exceptions\MiddlewareException|\Zaphyr\Router\Exceptions\RouteException|Zaphyr\Router\Exceptions\MethodNotAllowedException $e) {
    dd($e);
}