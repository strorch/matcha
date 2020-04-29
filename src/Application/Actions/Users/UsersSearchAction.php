<?php


namespace App\Application\Actions\Users;

use App\Application\Actions\AbstractJsonProxyAction;
use App\Domain\ValueObject\UserSearch;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Request;

class UsersSearchAction extends AbstractJsonProxyAction
{
    /**
     * @inheritDoc
     */
    protected function doAction(Request $request, Response $response, array $args)
    {
        // TODO think about it
        $search = $this->hydrator->hydrate($args ?? [], UserSearch::class);

        /** @var \App\Domain\Entity\User[] $res */
        return $this->userProvider->search($search);
    }
}
