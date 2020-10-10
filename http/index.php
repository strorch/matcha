<?php
declare(strict_types=1);

use App\Application\Handlers\HttpErrorHandler;
use App\Application\Handlers\ShutdownHandler;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

require __DIR__ . '/../vendor/autoload.php';

(static function (): void {
    /** @var \Psr\Container\ContainerInterface $container */
    $container = (require __DIR__ . '/../config/bootstrap.php')();
    /** @var \Closure $initializeRoutes */
    $initializeRoutes = require __DIR__ . '/../config/routes.php';

    $app = AppFactory::create(null, $container);
    call_user_func($initializeRoutes, $app);

    $errorHandler = new HttpErrorHandler($app->getCallableResolver(), $app->getResponseFactory());
    $displayErrorDetails = $container->get('settings')['displayErrorDetails'];
    $errorHandler->setDisplayErrorDetailsFlag($displayErrorDetails);

    $errorMiddleware = $app->addErrorMiddleware($errorHandler->getDisplayErrorDetailsFlag(), false, false);
    $errorMiddleware->setDefaultErrorHandler($errorHandler);

    $request = ServerRequestCreatorFactory::create()->createServerRequestFromGlobals();
    $shutdownHandler = new ShutdownHandler($request, $errorHandler);
    register_shutdown_function($shutdownHandler);

    $app->run();
})();
