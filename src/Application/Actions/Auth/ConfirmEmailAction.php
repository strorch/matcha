<?php
declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\AbstractUsersAction;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Request;

final class ConfirmEmailAction extends AbstractUsersAction
{
    /**
     * @inheritDoc
     */
    protected function doAction(Request $request, Response $response, array $args)
    {
        $params = json_decode((string)$request->getBody(), true);

        $user = $this->tokenProvider->find($params['token'] ?? '');
        if ($user) {
            return [
                'error' => 'empty or fake token',
            ];
        }

        $user->setEmailConfirmed();

        $this->userRepository->update($user);

        $this->session->set('user', $user);

        return $user;
    }
}
