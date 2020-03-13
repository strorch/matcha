<?php
declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Domain\DTO\UserSearch;
use App\Domain\Repository\Interfaces\UserRepositoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamFactoryInterface;
use Slim\Psr7\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class LoginAction
{
    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * GetDomainInfoAction constructor.
     * @param StreamFactoryInterface $streamFactory
     * @param UserRepositoryInterface $userRepository
     * @param SessionInterface $session
     */
    public function __construct(
        StreamFactoryInterface $streamFactory,
        UserRepositoryInterface $userRepository,
        SessionInterface $session
    ) {
        $this->streamFactory = $streamFactory;
        $this->userRepository = $userRepository;
        $this->session = $session;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $search = (new UserSearch())
                    ->setLogin($args['login'])
                    ->setPassword($args['password']);

        /** @var \App\Domain\Repository\User[] $res */
        $res = $this->userRepository->search($search);
        if (empty($res)) {
            return $response
                ->withBody($this->streamFactory->createStream('error'));
        }

        $this->session->set('user', reset($res));

        return $response
            ->withBody($this->streamFactory->createStream('success'));
    }
}
