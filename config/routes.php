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

    $app->get('/testCacheSet', function (Request $request, Response $response) use ($c): Response {
        $session = $c->get(SessionInterface::class);
        $session->set('user', 'kekekekkke');
        $response->getBody()->write($session->get('user') ?? 'empty');
        return $response;
    });
    $app->get('/testSendMail', function (Request $request, Response $response) use ($c): Response {
        $message = $c->get(\App\Infrastructure\Mail\CustomMessageFactory::class)
            ->create([
                'subject' => 'Wonderful Subject',
                'to' => 'xixexem852@septicvernon.com',
                'body' => 'Here is the message itself <a href="http://127.0.0.1:3000">Matcha</a>',
            ]);
        $mailer = $c->get(\App\Infrastructure\Mail\MailSenderInterface::class);
        $res = $mailer->send($message);
        $response->getBody()->write('message sent "' . $res . '" ' . getenv('MAILER_ENABLED'));
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
    $app->addRoutingMiddleware();
    $app->add(HttpHeadersMiddleware::class);
};
