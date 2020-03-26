<?php


namespace App\Application\Actions\Users;

use App\Application\Actions\AbstractUsersAction;
use App\Domain\ValueObject\UserSearch;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Request;

class UsersSearchAction extends AbstractUsersAction
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
        return $this->userRepository->search($search);
    }
}
