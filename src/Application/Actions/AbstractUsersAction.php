<?php


namespace App\Application\Actions;


use App\Domain\Repository\Interfaces\UserRepositoryInterface;
use App\Infrastructure\Mail\CustomMessageFactory;
use App\Infrastructure\Provider\SettingsProviderInterface;
use App\Infrastructure\Provider\TokenProviderInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamFactoryInterface;
use Slim\Psr7\Request;
use Swift_Mailer;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractUsersAction
{
    /**
     * @var StreamFactoryInterface
     */
    protected StreamFactoryInterface $streamFactory;

    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * @var SessionInterface
     */
    protected SessionInterface $session;

    /**
     * @var SerializerInterface
     */
    protected SerializerInterface $serializer;

    /**
     * @var Swift_Mailer
     */
    protected Swift_Mailer $mailer;

    /**
     * @var CustomMessageFactory
     */
    protected CustomMessageFactory $messageFactory;

    /**
     * @var TokenProviderInterface
     */
    protected TokenProviderInterface $tokenProvider;

    /**
     * @var SettingsProviderInterface
     */
    protected SettingsProviderInterface $settingsProvider;

    /**
     * GetDomainInfoAction constructor.
     * @param StreamFactoryInterface $streamFactory
     * @param UserRepositoryInterface $userRepository
     * @param SessionInterface $session
     * @param SerializerInterface $serializer
     * @param Swift_Mailer $mailer
     * @param CustomMessageFactory $messageFactory
     * @param TokenProviderInterface $tokenProvider
     * @param SettingsProviderInterface $settingsProvider
     */
    public function __construct(
        StreamFactoryInterface $streamFactory,
        UserRepositoryInterface $userRepository,
        SessionInterface $session,
        SerializerInterface $serializer,
        Swift_Mailer $mailer,
        CustomMessageFactory $messageFactory,
        TokenProviderInterface $tokenProvider,
        SettingsProviderInterface $settingsProvider
    ) {
        $this->streamFactory = $streamFactory;
        $this->userRepository = $userRepository;
        $this->session = $session;
        $this->serializer = $serializer;
        $this->mailer = $mailer;
        $this->messageFactory = $messageFactory;
        $this->tokenProvider = $tokenProvider;
        $this->settingsProvider = $settingsProvider;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return mixed
     */
    abstract protected function doAction(Request $request, Response $response, array $args);

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $responseData = $this->doAction($request, $response, $args);
        $serializedData = $this->serializer->serialize($responseData, 'json');
        $dataStream = $this->streamFactory->createStream($serializedData);

        return $response->withBody($dataStream);
    }
}
