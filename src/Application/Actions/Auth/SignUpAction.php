<?php
declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\AbstractUsersAction;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserSearch;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Request;
use Swift_Message;

final class SignUpAction extends AbstractUsersAction
{
    /**
     * @inheritDoc
     */
    protected function doAction(Request $request, Response $response, array $args)
    {
        $search = new UserSearch();
        $search->username = $args['username'] ?? null;

        $res = $this->userRepository->search($search);
        if (!empty($res)) {
            return 'error';
        }

        $user = (new User())
            ->setUsername($args['username'] ?? null)
            ->setPassword($args['password'] ?? null);

        if (!$this->userRepository->create($user)) {
            return 'error';
        }
        $this->session->set('user', $user);

        $this->sendNotifyEmail($user);

        return $user;
    }

    private function sendNotifyEmail(User $user): void
    {
        /** TODO: email templating */
        /** @var Swift_Message $message */
        $message = $this->messageFactory->create('Wonderful Subject')
            ->setTo(['receiver@domain.org', 'other@domain.org' => 'A name'])
            ->setBody('Here is the message itself');
        $this->mailer->send($message);
    }
}
