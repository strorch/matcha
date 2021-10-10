<?php
declare(strict_types=1);

use App\Application\Handler\HttpErrorHandler;
use App\Application\Handler\ShutdownHandler;
use DI\Bridge\Slim\Bridge;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Factory\ServerRequestCreatorFactory;

require __DIR__ . '/../vendor/autoload.php';

(static function (): void {
    /** @var \Psr\Container\ContainerInterface $container */
    $container = (require __DIR__ . '/../config/bootstrap.php')();
    /** @var \Closure $initializeRoutes */
    $initializeRoutes = require __DIR__ . '/../config/routes.php';

    $app = Bridge::create($container);
    call_user_func($initializeRoutes, $app);

    $errorHandler = new HttpErrorHandler($app->getCallableResolver(), $app->getResponseFactory());
    $displayErrorDetails = $container->get('settings')['displayErrorDetails'];
    $errorHandler->setDisplayErrorDetailsFlag($displayErrorDetails);

    $errorMiddleware = $app->addErrorMiddleware($errorHandler->getDisplayErrorDetailsFlag(), false, false);
    $errorMiddleware->setDefaultErrorHandler($errorHandler);

    $request = $container->get(ServerRequestInterface::class);
    $shutdownHandler = new ShutdownHandler($request, $errorHandler);
    register_shutdown_function($shutdownHandler);

    $app->run($request);
})();
