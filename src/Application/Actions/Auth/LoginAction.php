<?php
declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\AbstractUsersAction;
use App\Domain\ValueObject\UserSearch;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Request;

final class LoginAction extends AbstractUsersAction
{
    /**
     * @inheritDoc
     */
    protected function doAction(Request $request, Response $response, array $args)
    {
        $search = new UserSearch();
        $search->username = $args['username'] ?? null;
        $search->password = $args['password'] ?? null;

        /** @var \App\Domain\Entity\User[] $res */
        $res = $this->userRepository->search($search);
        if (empty($res)) {
            return 'error';
        }

        $res = reset($res);
        $this->session->set('user', $res);

        return $res;
    }
}
