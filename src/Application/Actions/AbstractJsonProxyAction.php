<?php


namespace App\Application\Actions;


use App\Domain\Repository\Interfaces\UserRepositoryInterface;
use App\Infrastructure\Mail\CustomMessageFactory;
use App\Infrastructure\Provider\SettingsProviderInterface;
use App\Infrastructure\Provider\TokenProviderInterface;
use App\Infrastructure\Provider\UserProviderInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamFactoryInterface;
use Slim\Psr7\Request;
use App\Infrastructure\Mail\MailerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Zend\Hydrator\HydratorInterface;

abstract class AbstractJsonProxyAction
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
     * @var MailerInterface
     */
    protected MailerInterface $mailer;

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
     * @var HydratorInterface
     */
    protected HydratorInterface $hydrator;

    /**
     * @var UserProviderInterface
     */
    protected UserProviderInterface $userProvider;

    /**
     * TODO: refactor
     * GetDomainInfoAction constructor.
     * @param StreamFactoryInterface $streamFactory
     * @param SerializerInterface $serializer
     *
     * @param UserRepositoryInterface $userRepository
     * @param SessionInterface $session
     * @param TokenProviderInterface $tokenProvider
     * @param HydratorInterface $hydrator
     * @param UserProviderInterface $userProvider
     *
     * @param MailerInterface $mailer
     * @param CustomMessageFactory $messageFactory
     * @param SettingsProviderInterface $settingsProvider
     */
    public function __construct(
        StreamFactoryInterface $streamFactory,
        UserRepositoryInterface $userRepository,
        SessionInterface $session,
        SerializerInterface $serializer,
        MailerInterface $mailer,
        CustomMessageFactory $messageFactory,
        TokenProviderInterface $tokenProvider,
        HydratorInterface $hydrator,
        UserProviderInterface $userProvider,
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
        $this->hydrator = $hydrator;
        $this->userProvider = $userProvider;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     *
     * @return mixed
     * @throws \Throwable
     */
    abstract protected function doAction(Request $request, Response $response, array $args);

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    final public function __invoke(Request $request, Response $response, array $args): Response
    {
        $responseData = [
            'data'  => null,
            'error' => null,
        ];
        try {
            $responseData['data'] = $this->doAction($request, $response, $args);
        } catch (\Throwable $e) {
            $responseData['error'] = $e->getMessage();
        }
        $serializedData = $this->serializer->serialize($responseData, 'json');
        $dataStream = $this->streamFactory->createStream($serializedData);

        return $response->withBody($dataStream);
    }
}
