<?php
declare(strict_types=1);

use App\Application\Action\Interest\CreateInterestAction;
use App\Application\Action\User\ConfirmEmailAction;
use App\Application\Action\User\SignUpAction;
use App\Application\Action\User\UsersSearchAction;
use App\Application\Action\User\UserUpdateAction;
use App\Application\Middleware\HttpHeadersMiddleware;
use App\Infrastructure\Mail\CustomMessageFactory;
use App\Infrastructure\Mail\MailSenderInterface;
use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Yiisoft\DataResponse\Middleware\FormatDataResponseAsJson;

return static function (App $app): void {
    $c = $app->getContainer();

    $app->get('/testSendMail', function (Response $response, MailSenderInterface $mailSender, CustomMessageFactory $customMessageFactory): Response {
        $message = $customMessageFactory->create([
            'subject' => 'Wonderful Subject',
            'to' => 'xixexem852@septicvernon.com',
            'body' => 'Here is the message itself <a href="http://127.0.0.1:3000">Matcha</a>',
        ]);
        $res = $mailSender->send($message);
        $response->getBody()->write('message sent "' . $res . '" ' . getenv('MAILER_ENABLED'));
        return $response;
    });

    $app->group('/api/v1', function (Group $api) {
//        $api->post('/issueToken', )

        $api->group('/user', function (Group $user) {
            $user->post('', SignUpAction::class);
            $user->patch('/confirm-email', ConfirmEmailAction::class);

            $user->group('', function (Group $user) {
                $user->get('s', UsersSearchAction::class);
                $user->put('',  UserUpdateAction::class);
            })
                ->add(\Slim\Middleware\Authentication\JwtAuthentication::class);
        });

        $api->group('/interest', function (Group $interest) {
//            $interest->get('/interest',  CreateInterestAction::class);
            $interest->post('/interest',  CreateInterestAction::class);
        });
    });

    $app->addMiddleware($c->get(FormatDataResponseAsJson::class));
    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();
    $app->add($c->get(HttpHeadersMiddleware::class));
};
