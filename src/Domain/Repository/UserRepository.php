<?php


namespace App\Domain\Repository;


use App\Domain\Entity\User;
use App\Domain\Repository\Interfaces\ContactRepositoryInterface;
use App\Domain\Repository\Interfaces\UserRepositoryInterface;
use App\Domain\ValueObject\UserSearch;
use App\Infrastructure\DB\DB;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * @var ContactRepositoryInterface
     */
    private ContactRepositoryInterface $contactRepository;

    public function __construct(DB $db, ContactRepositoryInterface $contactRepository)
    {
        parent::__construct($db);

        $this->contactRepository = $contactRepository;
    }

    /**
     * @inheritDoc
     */
    public function create(User $user): bool
    {


        return true;
    }

    /**
     * @inheritDoc
     */
    public function search(UserSearch $search): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function update(User $user): bool
    {
        if (!empty($user->getContact())) {
            $this->contactRepository->setContact($user->getId(), $user->getContact());
        }
        return true;
    }
}
