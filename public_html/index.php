<?php

use AdamAinsworth\HanoiChallenge\Hanoi;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->redirect('/', '/state', 301);

$app->get('/state', function (Request $request, Response $response, $args) {
    $hanoi = Hanoi::load();

    header('Content-Type: application/json');
    $response->getBody()->write( $hanoi->serialise() );

    return $response;
});

$app->get('/move/{from}/{to}', function (Request $request, Response $response, $args) {
    if( isset($args['from']) && isset($args['to']) ) {
        $from = intval($args['from']);
        $to = intval($args['to']);

        if( is_int($from) && is_int($to) ) {
            $response->getBody()->write("Move from " . $from . " to " . $to);
        }
    }

    return $response;
});

$app->run();
