<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';
$app = new Slim\App();

$app->get('/operation/add/{params:.*}', function (Request $request, Response $response, array $args) {
    $params = explode('/', $args['params']);
    $result = array_sum($params);
    return $response->withJson(['result' => $result, 'success' => true]);
});

$app->get('/operation/subtract/{params:.*}', function (Request $request, Response $response, array $args) {
    $params = explode('/', $args['params']);
    $result = array_shift($params);
    foreach ($params as $param) {
        $result -= $param;
    }
    return $response->withJson(['result' => $result, 'success' => true]);
});

$app->get('/operation/multiply/{params:.*}', function (Request $request, Response $response, array $args) {
    $params = explode('/', $args['params']);
    $result = array_product($params);
    return $response->withJson(['result' => $result, 'success' => true]);
});

$app->get('/operation/divide/{params:.*}', function (Request $request, Response $response, array $args) {
    $params = explode('/', $args['params']);
    $result = array_shift($params);
    foreach ($params as $param) {
        try {
            $result /= $param;
        } catch(\DivisionByZeroError $e) {
            return $response->withStatus(400)->withJson(['error' => 'Division by zero', 'success' => false]);
        }
    }
    return $response->withJson(['result' => $result, 'success' => true]);
});

$app->run();
