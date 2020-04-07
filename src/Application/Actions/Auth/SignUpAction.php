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

        try {
            $this->sendConfirmEmail($user);
        } catch (\Exception $e) {
            return 'error: ' . $e->getMessage();
        }

        return $user;
    }

    /**
     * @param User $user
     * @throws \Exception
     */
    private function sendConfirmEmail(User $user): void
    {
        $hash = $this->tokenProvider->saveUser($user);
        $link = $this->prepareLink($hash);

        /** @var Swift_Message $message */
        $message = $this->messageFactory->create('Matcha: confirm your email!')
            ->setTo([$user->getEmail() => $user->getEmail()])
            ->setBody("Visit <a href='$link'>link</a> to confirm your email", 'text/html');

        if (empty($this->mailer->send($message))) {
            throw new \Exception('failed to send email');
        }
    }

    private function prepareLink(string $hash): string
    {
        $clientUrl = $this->settingsProvider->getSettingByName('clientUrl');

        return $clientUrl . '/confirm-email?token=' . $hash;
    }
}
