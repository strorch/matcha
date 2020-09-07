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

        /**
         * TODO refactor exceptions to assert methods
         */

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

        $message = $this->messageFactory->create([
            'subject' => 'Matcha: confirm your email!',
            'to' => $user->getEmail(),
            'body' => "Visit <a href='$link'>link</a> to confirm your email",
        ]);

        $this->mailer->send($message);
    }

    private function prepareLink(string $hash): string
    {
        $clientUrl = $this->settingsProvider->getSettingByName('clientUrl');

        return $clientUrl . '/confirm-email?token=' . $hash;
    }
}
