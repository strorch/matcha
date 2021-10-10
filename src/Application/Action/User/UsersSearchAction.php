<?php


namespace App\Application\Action\User;

use App\Application\Actions\AbstractRestAction;
use App\Domain\Repository\Interfaces\UserRepositoryInterface;
use App\Domain\DTO\UserSearch;
use App\Infrastructure\Hydrator\UserSearchHydrator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamFactoryInterface;
use Slim\Psr7\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Zend\Hydrator\HydratorInterface;

final class UsersSearchAction extends AbstractRestAction
{
    /** @var HydratorInterface|UserSearchHydrator  */
    private HydratorInterface $hydrator;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        StreamFactoryInterface $streamFactory,
        SerializerInterface $serializer,
        UserRepositoryInterface $userRepository,
        HydratorInterface $hydrator
    ) {
        parent::__construct($streamFactory, $serializer);
        $this->hydrator = $hydrator;
        $this->userRepository = $userRepository;
    }

    /**
     * @inheritDoc
     */
    protected function doAction(Request $request, Response $response)
    {
        $search = $this->hydrator->hydrate($request->getQueryParams(), UserSearch::class);

        /** @var \App\Domain\Entity\User[] $res */
        return $this->userRepository->search($search);
    }
}
