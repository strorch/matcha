<?php
declare(strict_types=1);

namespace App\Application\Action\User;

use App\Application\Actions\AbstractRestAction;
use App\Domain\Repository\Interfaces\UserRepositoryInterface;
use App\Infrastructure\Provider\TokenProviderInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamFactoryInterface;
use Slim\Psr7\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class ConfirmEmailAction extends AbstractRestAction
{
    private TokenProviderInterface $tokenProvider;
    private UserRepositoryInterface $userRepository;
    private SessionInterface $session;

    public function __construct(
        StreamFactoryInterface $streamFactory,
        SerializerInterface $serializer,
        TokenProviderInterface $tokenProvider,
        UserRepositoryInterface $userRepository,
        SessionInterface $session
    ) {
        parent::__construct($streamFactory, $serializer);
        $this->tokenProvider = $tokenProvider;
        $this->userRepository = $userRepository;
        $this->session = $session;
    }

    /**
     * @inheritDoc
     */
    protected function doAction(Request $request, Response $response)
    {
        ['token' => $token] = $request->getParsedBody();

        $user = $this->tokenProvider->find($token ?? '');
        if (empty($user)) {
            throw new \Exception('empty or fake token');
        }

        $user->setEmailConfirmed();

        $this->userRepository->update($user);

        $this->session->set('user', $user);

        $this->tokenProvider->remove($token);

        return $user;
    }
}
