<?php


namespace App\Domain\Repository;


use App\Domain\ValueObject\UserSearch;
use App\Domain\Repository\Interfaces\UserRepositoryInterface;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(User $client): bool
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
    public function update(int $userId, User $client): bool
    {
        return true;
    }
}
