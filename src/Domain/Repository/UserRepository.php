<?php


namespace App\Domain\Repository;


use App\Domain\Entity\User;
use App\Domain\Repository\Interfaces\UserRepositoryInterface;
use App\Domain\ValueObject\UserSearch;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
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
        return true;
    }
}
