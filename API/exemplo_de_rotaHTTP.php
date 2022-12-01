<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once "vendor/autoload.php";

$app = new \Slim\App();



$app->get('/produtos', function (Request $request, Response $response, array $args): Response {

    $response->getBody()->write('Produtos do banco de dados ');
    return $response;
});

$app->post('/produtos', function (Request $request, Response $response, array $args): Response {

    $data = $request->getParsedBody();

    $nome = $data['nome'] ?? '';


    $response->getBody()->write("Produtos {$nome}  {post}");
    return $response;
});

$app->put('/produtos', function (Request $request, Response $response, array $args): Response {
    $data = $request->getParsedBody();

    $nome = $data['nome'] ?? '';


    $response->getBody()->write("Produtos {$nome}  {put}");
    return $response;
});

$app->delete('/produtos', function (Request $request, Response $response, array $args): Response {
    $data = $request->getParsedBody();

    $nome = $data['nome'] ?? '';


    $response->getBody()->write("Produtos {$nome}  {delete}");
    return $response;
});





$app->run();
