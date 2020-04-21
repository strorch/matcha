<?php


namespace App\Domain\Repository\Interfaces;


use App\Domain\ValueObject\UserSearch;
use App\Domain\Entity\User;

interface UserRepositoryInterface
{
    /**
     * Returns boolean result of operation
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool;

    /**
     * Returns a search result which is a array of [[User]] entities
     * @see User
     *
     * @param UserSearch $search
     * @return User[]
     */
    public function search(UserSearch $search): array;

    /**
     * @param User $user
     * @return bool
     */
    public function update(User $user): bool;
}
