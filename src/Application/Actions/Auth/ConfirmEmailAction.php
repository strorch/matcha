<?php
declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\AbstractJsonProxyAction;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Request;

final class ConfirmEmailAction extends AbstractJsonProxyAction
{
    /**
     * @inheritDoc
     */
    protected function doAction(Request $request, Response $response, array $args)
    {
        $body = $request->getParsedBody();

        $user = $this->tokenProvider->find($body['token'] ?? '');
        if (empty($user)) {
            throw new \Exception('empty or fake token');
        }

        $user->setEmailConfirmed();

        $this->userRepository->update($user);

        $this->session->set('user', $user);

        $this->tokenProvider->remove($body['token']);

        return $user;
    }
}
