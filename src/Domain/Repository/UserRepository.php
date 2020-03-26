<?php


namespace App\Domain\Repository;


use App\Domain\Entity\User;
use App\Domain\ValueObject\UserSearch;

class UserRepository extends AbstractRepository
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
