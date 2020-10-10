<?php
declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\AbstractRestAction;
use App\Domain\ValueObject\UserSearch;
use App\Infrastructure\Provider\UserProviderInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamFactoryInterface;
use Slim\Psr7\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Zend\Hydrator\HydratorInterface;

final class LoginAction extends AbstractRestAction
{
    private HydratorInterface $hydrator;
    private UserProviderInterface $userProvider;
    private SessionInterface $session;

    public function __construct(
        StreamFactoryInterface $streamFactory,
        SerializerInterface $serializer,
        HydratorInterface $hydrator,
        UserProviderInterface $userProvider,
        SessionInterface $session
    ) {
        parent::__construct($streamFactory, $serializer);
        $this->hydrator = $hydrator;
        $this->userProvider = $userProvider;
        $this->session = $session;
    }

    /**
     * @inheritDoc
     */
    protected function doAction(Request $request, Response $response, array $args)
    {
        ['user' => $body] = $request->getParsedBody();

        $search = $this->hydrator->hydrate($body, UserSearch::class);

        $res = $this->userProvider->search($search);
        if (empty($res)) {
            throw new \Exception('user does not exists');
        }

        $res = reset($res);
        $this->session->set('user', $res);

        return ['user' => $res];
    }
}
