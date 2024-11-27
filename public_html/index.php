<?php

use AdamAinsworth\HanoiChallenge\Hanoi;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

// TODO - put these in env vars
define('STATE_JSON', '/tmp/state.json');
define('NUMBER_PEGS', 3);
define('NUMBER_DISKS', 7);

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->redirect('/', '/state', 301);

$app->get('/state', function (Request $request, Response $response, $args) {
    $hanoi = Hanoi::create();

    header('Content-Type: application/json');
    $response->getBody()->write( $hanoi->return_state() );

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

/*
Initial serialised object will look something like

O:34:"AdamAinsworth\HanoiChallenge\Hanoi":1:{s:4:"pegs";a:3:{i:0;O:32:"AdamAinsworth\HanoiChallenge\Peg":2:{s:5:"index";i:1;s:5:"disks";a:7:{i:0;O:33:"AdamAinsworth\HanoiChallenge\Disk":3:{s:4:"size";i:0;s:4:"name";s:6:"disk-0";s:6:"colour";s:7:"#e27e10";}i:1;O:33:"AdamAinsworth\HanoiChallenge\Disk":3:{s:4:"size";i:1;s:4:"name";s:6:"disk-1";s:6:"colour";s:7:"#3622c8";}i:2;O:33:"AdamAinsworth\HanoiChallenge\Disk":3:{s:4:"size";i:2;s:4:"name";s:6:"disk-2";s:6:"colour";s:7:"#92bef1";}i:3;O:33:"AdamAinsworth\HanoiChallenge\Disk":3:{s:4:"size";i:3;s:4:"name";s:6:"disk-3";s:6:"colour";s:7:"#714b19";}i:4;O:33:"AdamAinsworth\HanoiChallenge\Disk":3:{s:4:"size";i:4;s:4:"name";s:6:"disk-4";s:6:"colour";s:7:"#09a1ac";}i:5;O:33:"AdamAinsworth\HanoiChallenge\Disk":3:{s:4:"size";i:5;s:4:"name";s:6:"disk-5";s:6:"colour";s:7:"#c452ad";}i:6;O:33:"AdamAinsworth\HanoiChallenge\Disk":3:{s:4:"size";i:6;s:4:"name";s:6:"disk-6";s:6:"colour";s:7:"#68d84a";}}}i:1;O:32:"AdamAinsworth\HanoiChallenge\Peg":2:{s:5:"index";i:2;s:5:"disks";a:0:{}}i:2;O:32:"AdamAinsworth\HanoiChallenge\Peg":2:{s:5:"index";i:3;s:5:"disks";a:0:{}}}}
*/
