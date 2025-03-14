<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use toubeelib\application\middlewares\AuthMiddleware;
use toubeelib\application\middlewares\Cors;



$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/settings.php' );
$builder->addDefinitions(__DIR__ . '/dependencies.php');

$c=$builder->build();
$app = AppFactory::createFromContainer($c);

$app->add(new Cors());
//$app->add(AuthMiddleware::class);

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware($c->get('displayErrorDetails'), false, false);


//    ->getDefaultErrorHandler()
//    ->forceContentType('application/json')
;


$app = (require_once __DIR__ . '/routes.php')($app);
$routeParser = $app->getRouteCollector()->getRouteParser();


return $app;