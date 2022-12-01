<?php

use Psr\Http\Message\ServerRequestInterface as Request;

use Psr\Http\Message\ResponseInterface as Response;

require_once "vendor/autoload.php";

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$configuration = new \Slim\Container($configuration);

$mid01 = function (Request $request, Response $response, $next): Response {
    $response->getBody()->write("DENTRO DO MIDDLEWARE 01<br>");
    $response = $next($request, $response);

    $response->getBody()->write("<br>DENTRO DO MIDDLEWARE 02");

    return $response;
};

$app = new \Slim\App($configuration);

$app->post('/curso', function (Request $request, Response $response, array $args): Response {

    $data = $request->getParsedBody();

    $nome = $data['nome'] ?? '';


    $response->getBody()->write("Produto {$nome} ");
    return $response;
})->add($mid01);

$app->run();
