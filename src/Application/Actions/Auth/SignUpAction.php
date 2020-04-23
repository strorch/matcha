<?php
declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\AbstractJsonProxyAction;
use App\Domain\Entity\User;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Request;

final class SignUpAction extends AbstractJsonProxyAction
{
    /**
     * @inheritDoc
     */
    protected function doAction(Request $request, Response $response, array $args)
    {
        ['user' => $body] = $request->getParsedBody();

        /** @var User $user */
        $user = $this->hydrator->hydrate($body, User::class);

        $this->userRepository->create($user);

        $this->session->set('user', $user);

        $this->sendConfirmEmail($user);

        return ['user' => $user];
    }

    /**
     * @param User $user
     * @throws \Exception
     */
    private function sendConfirmEmail(User $user): void
    {
        $hash = $this->tokenProvider->saveUser($user);
        $link = $this->prepareLink($hash);

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
