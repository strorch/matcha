<?php
declare(strict_types=1);

use App\Application\Actions\Auth\LoginAction;
use App\Application\Actions\Auth\SignUpAction;
use App\Socket\Client\SocketClient;
use Slim\App;
use App\Application\Middleware\CheckAuthMiddleware;
use App\Application\Middleware\JSONSerializeMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return static function (App $app): void {
    $c = $app->getContainer();

    $app->get('/', function (Request $request, Response $response) use ($c): Response {

        $client = $c->get(SocketClient::class);

        $client->sendNotify();

        $response->getBody()->write('Hello! It\'s Matcha API version 1.0!');
        return $response;
    });

    $app->group('/auth', function (Group $group) {
        $group->post('/login', LoginAction::class);
        $group->post('/signUp', SignUpAction::class);
    });

    $app->group('/api', function (Group $group) {
        $group->get('/', function (Request $request, Response $response, array $params): Response {
            return $response;
        });
       $group->get('/{entities}', function (Request $request, Response $response, array $params): Response {
           return $response;
       });
//        $group->get('/client', function (Request $request, Response $response, array $params): Response {
//            return $response;
//        });
//        $app->get('/', \HomeController::class . ':home');
    })
        ->addMiddleware(new CheckAuthMiddleware())
        ->addMiddleware(new JSONSerializeMiddleware());
};
