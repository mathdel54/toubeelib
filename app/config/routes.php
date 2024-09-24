<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function( \Slim\App $app):\Slim\App {

    $app->get('/', \toubeelib\application\actions\HomeAction::class);

    $app->get('/Rdvs/{id}', \toubeelib\application\actions\ConsulterRdvAction::class);

    $app->patch('/Rdvs/{id}', \toubeelib\application\actions\ModifierRdvAction::class);


    return $app;
};