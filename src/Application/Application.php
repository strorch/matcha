<?php


namespace App\Application;


use App\Application\Handlers\HttpErrorHandler;
use App\Application\Handlers\ShutdownHandler;
use App\Application\ResponseEmitter\ResponseEmitter;
use Closure;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

/**
 * Class Application
 * @package App\Application
 */
final class Application
{
    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * @var Closure
     */
    private Closure $routes;

    public function __construct(ContainerInterface $container, Closure $routes)
    {
        $this->container = $container;
        $this->routes = $routes;
    }

    public function run(): void
    {
        // Instantiate the app
        AppFactory::setContainer($this->container);
        $app = AppFactory::create();
        $callableResolver = $app->getCallableResolver();

        // Register routes
        call_user_func($this->routes, $app);

        /** @var bool $displayErrorDetails */
        $displayErrorDetails = $this->container->get('settings')['displayErrorDetails'];

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
    }
}
