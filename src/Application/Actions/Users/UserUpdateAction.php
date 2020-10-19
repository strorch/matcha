<?php


namespace App\Application\Actions\Users;


use App\Application\Actions\AbstractRestAction;
use App\Domain\Entity\User;
use App\Domain\Repository\Interfaces\UserRepositoryInterface;
use App\Domain\ValueObject\UserProfileData;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamFactoryInterface;
use Slim\Psr7\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Zend\Hydrator\HydratorInterface;

final class UserUpdateAction extends AbstractRestAction
{
    private HydratorInterface $hydrator;
    private UserRepositoryInterface $userRepository;
    private SessionInterface $session;

    public function __construct(
        StreamFactoryInterface $streamFactory,
        SerializerInterface $serializer,
        HydratorInterface $hydrator,
        UserRepositoryInterface $userRepository,
        SessionInterface $session
    ) {
        parent::__construct($streamFactory, $serializer);
        $this->hydrator = $hydrator;
        $this->userRepository = $userRepository;
        $this->session = $session;
    }

    /**
     * @inheritDoc
     */
    protected function doAction(Request $request, Response $response, array $args)
    {
        ['user' => $body] = $request->getParsedBody();

        $user = $this->hydrator->hydrate($body, User::class);

        $this->userRepository->update($user);

        $this->session->set('user', $user);

        return ['user' => $user];
    }
}
