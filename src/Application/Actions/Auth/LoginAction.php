<?php
declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\AbstractJsonProxyAction;
use App\Domain\ValueObject\UserSearch;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Request;

final class LoginAction extends AbstractJsonProxyAction
{
    /**
     * @inheritDoc
     */
    protected function doAction(Request $request, Response $response, array $args)
    {
        ['user' => $body] = $request->getParsedBody();

        $search = $this->hydrator->hydrate($body, UserSearch::class);

        $res = $this->userProvider->search($search);
        if (empty($res)) {
            throw new \Exception('user does not exists');
        }

        $res = reset($res);
        $this->session->set('user', $res);

        return ['user' => $res];
    }
}
