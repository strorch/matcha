<?php


namespace App\Application\Actions\Users;


use App\Application\Actions\AbstractUsersAction;
use App\Domain\ValueObject\Contact;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Request;

class UserUpdateAction extends AbstractUsersAction
{
    /**
     * @inheritDoc
     */
    protected function doAction(Request $request, Response $response, array $args)
    {
        $contact = new Contact();
        $contact->gender = $args['gender'];

        return 'error';
    }
}
