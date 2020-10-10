<?php
declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\AbstractRestAction;
use App\Domain\Entity\User;
use App\Domain\Repository\Interfaces\UserRepositoryInterface;
use App\Infrastructure\Mail\CustomMessageFactory;
use App\Infrastructure\Mail\MailerInterface;
use App\Infrastructure\Provider\SettingsProviderInterface;
use App\Infrastructure\Provider\TokenProviderInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamFactoryInterface;
use Slim\Psr7\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Zend\Hydrator\HydratorInterface;

final class SignUpAction extends AbstractRestAction
{
    private HydratorInterface $hydrator;
    private UserRepositoryInterface $userRepository;
    private SessionInterface $session;
    private SettingsProviderInterface $settingsProvider;
    private MailerInterface $mailer;
    private CustomMessageFactory $messageFactory;
    private TokenProviderInterface $tokenProvider;

    public function __construct(
        StreamFactoryInterface $streamFactory,
        SerializerInterface $serializer,
        HydratorInterface $hydrator,
        UserRepositoryInterface $userRepository,
        SessionInterface $session,
        SettingsProviderInterface $settingsProvider,
        MailerInterface $mailer,
        CustomMessageFactory $messageFactory,
        TokenProviderInterface $tokenProvider
    ) {
        parent::__construct($streamFactory, $serializer);
        $this->hydrator = $hydrator;
        $this->userRepository = $userRepository;
        $this->session = $session;
        $this->settingsProvider = $settingsProvider;
        $this->mailer = $mailer;
        $this->messageFactory = $messageFactory;
        $this->tokenProvider = $tokenProvider;
    }

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
