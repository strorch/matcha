<?php
declare(strict_types=1);

use App\Application\Handlers\HttpErrorHandler;
use App\Application\Handlers\ShutdownHandler;
use App\Application\ResponseEmitter\ResponseEmitter;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

require __DIR__ . '/../vendor/autoload.php';

(static function () {

    /** @var \Psr\Container\ContainerInterface $container */
    $container = (require __DIR__ . '/../config/bootstrap.php')();

    // Instantiate the app
    AppFactory::setContainer($container);
    $app = AppFactory::create();
    $callableResolver = $app->getCallableResolver();

    // Register routes
    $routes = require __DIR__ . '/../config/routes.php';
    $routes($app);

    /** @var bool $displayErrorDetails */
    $displayErrorDetails = $container->get('settings')['displayErrorDetails'];

    // Create Request object from globals
    $serverRequestCreator = ServerRequestCreatorFactory::create();
    $request = $serverRequestCreator->createServerRequestFromGlobals();

    // Create Error Handler
    $responseFactory = $app->getResponseFactory();
    $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
    $errorHandler->setDisplayErrorDetailsFlag($displayErrorDetails);

    // Create Shutdown Handler
    $shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
    register_shutdown_function($shutdownHandler);

    // Add Routing Middleware
    $app->addRoutingMiddleware();

    // Add Error Middleware
    $errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, false, false);
    $errorMiddleware->setDefaultErrorHandler($errorHandler);

    // Run App & Emit Response
    $response = $app->handle($request);
    $responseEmitter = new ResponseEmitter();
    $responseEmitter->emit($response);
})();
