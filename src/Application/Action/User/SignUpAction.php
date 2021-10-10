<?php
declare(strict_types=1);

namespace App\Application\Action\User;

use App\Domain\Entity\User;
use App\Domain\Repository\Interfaces\UserRepositoryInterface;
use App\Infrastructure\Hydrator\UserHydrator;
use App\Infrastructure\Mail\CustomMessageFactory;
use App\Infrastructure\Mail\MailSenderInterface;
use App\Infrastructure\Provider\SettingsProviderInterface;
use App\Infrastructure\Provider\TokenProviderInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Zend\Hydrator\HydratorInterface;

final class SignUpAction
{
    /** @var HydratorInterface|UserHydrator  */
    private HydratorInterface $hydrator;
    private UserRepositoryInterface $userRepository;
    private SettingsProviderInterface $settingsProvider;
    private MailSenderInterface $mailSender;
    private CustomMessageFactory $messageFactory;
    private TokenProviderInterface $tokenProvider;
    private DataResponseFactoryInterface $responseFactory;

    public function __construct(
        HydratorInterface $hydrator,
        UserRepositoryInterface $userRepository,
        SettingsProviderInterface $settingsProvider,
        MailSenderInterface $mailSender,
        CustomMessageFactory $messageFactory,
        DataResponseFactoryInterface $responseFactory,
        TokenProviderInterface $tokenProvider
    ) {
        $this->hydrator = $hydrator;
        $this->userRepository = $userRepository;
        $this->settingsProvider = $settingsProvider;
        $this->mailSender = $mailSender;
        $this->messageFactory = $messageFactory;
        $this->tokenProvider = $tokenProvider;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @inheritDoc
     */
    public function __invoke(Request $request): ResponseInterface
    {
        ['user' => $body] = $request->getParsedBody();

        $user = $this->hydrator->hydrate($body, User::class);

        $this->userRepository->create($user);
        //TODO: check exception after create and validation


        //TODO: move it to event dispatcher and throw log if not possible to do
//        $this->sendConfirmEmail($user);

        return $this->responseFactory->createResponse(['user' => $this->hydrator->extract($user)]);
    }

    private function sendConfirmEmail(User $user): void
    {
        $hash = $this->tokenProvider->saveUser($user);
        $link = $this->prepareLink($hash);

        $message = $this->messageFactory->create([
            'subject' => 'Matcha: confirm your email!',
            'to' => $user->getEmail(),
            'body' => "Visit <a href='$link'>link</a> to confirm your email",
        ]);

        $this->mailSender->send($message);
    }

    private function prepareLink(string $hash): string
    {
        $clientUrl = $this->settingsProvider->getSettingByName('clientUrl');

        return $clientUrl . '/confirm-email?token=' . $hash;
    }
}
