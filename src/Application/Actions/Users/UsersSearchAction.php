<?php


namespace App\Application\Actions\Users;

use App\Application\Actions\AbstractRestAction;
use App\Domain\ValueObject\UserSearch;
use App\Infrastructure\Provider\UserProviderInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamFactoryInterface;
use Slim\Psr7\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Zend\Hydrator\HydratorInterface;

class UsersSearchAction extends AbstractRestAction
{
    private UserProviderInterface $userProvider;
    private HydratorInterface $hydrator;

    public function __construct(
        StreamFactoryInterface $streamFactory,
        SerializerInterface $serializer,
        UserProviderInterface $userProvider,
        HydratorInterface $hydrator
    ) {
        parent::__construct($streamFactory, $serializer);
        $this->userProvider = $userProvider;
        $this->hydrator = $hydrator;
    }

    /**
     * @inheritDoc
     */
    protected function doAction(Request $request, Response $response, array $args)
    {
        // TODO think about it
        $search = $this->hydrator->hydrate($args ?? [], UserSearch::class);

        /** @var \App\Domain\Entity\User[] $res */
        return $this->userProvider->search($search);
    }
}
