<?php


namespace App\Application\Actions\Users;


use App\Application\Actions\AbstractJsonProxyAction;
use App\Domain\Entity\User;
use App\Domain\ValueObject\Contact;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Request;

class UserUpdateAction extends AbstractJsonProxyAction
{
    /**
     * @inheritDoc
     */
    protected function doAction(Request $request, Response $response, array $args)
    {
        ['user' => $body] = $request->getParsedBody();

        $user = $this->hydrator->hydrate($body, User::class);

        $this->userRepository->update($user);

        $this->session->set('user', $user);

        return ['user' => $user];
    }
}
