<?php
declare(strict_types=1);

use App\Application\Actions\Auth\ConfirmEmailAction;
use App\Application\Actions\Auth\LoginAction;
use App\Application\Actions\Auth\SignUpAction;
use App\Application\Actions\Users\UsersSearchAction;
use App\Application\Actions\Users\UserUpdateAction;
use App\Application\Middleware\CheckGuestMiddleware;
use App\Application\Middleware\HttpHeadersMiddleware;
use App\Application\Middleware\ValidateInputMiddleware;
use Slim\App;
use App\Application\Middleware\CheckAuthMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

return static function (App $app): void {
    $c = $app->getContainer();

    $app->get('/', function (Request $request, Response $response) use ($c): Response {
        $response->getBody()->write('hello api');
        return $response;
    });

    $app->group('/auth', function (Group $group) use ($c) {
        $group->post('/login', LoginAction::class)
            ->add(CheckGuestMiddleware::class);
        $group->post('/signUp', SignUpAction::class)
            ->add(CheckGuestMiddleware::class);
        $group->post('/logout', function (Request $request, Response $response, array $params) use ($c): Response {
                $c->get(SessionInterface::class)->clear();
                return $response;
            })
            ->add(CheckAuthMiddleware::class);
        $group->patch('/confirm-email', ConfirmEmailAction::class);
    });

    $app->group('/api', function (Group $group) {
        $group->get('/users', UsersSearchAction::class);
        $group->put('/user',  UserUpdateAction::class);
    })->add(CheckAuthMiddleware::class);

    $app->add(ValidateInputMiddleware::class);
    $app->addBodyParsingMiddleware();
    $app->add(HttpHeadersMiddleware::class);
    $app->addRoutingMiddleware();
};
