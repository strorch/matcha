<?php


namespace App\Application\Actions\Users;


use App\Application\Actions\AbstractJsonProxyAction;
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

        $contact = new Contact();
        $contact->gender = $body['gender'];
    }
}
