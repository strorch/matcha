<?php


namespace App\Domain\Repository\Interfaces;


use App\Domain\DTO\UserSearch;
use App\Domain\Repository\User;

interface UserRepositoryInterface
{
    /**
     * Returns boolean result of operation
     *
     * @param User $client
     * @return bool
     */
    public function create(User $client): bool;

    /**
     * Returns a search result which is a array of [[User]] entities
     * @see User
     *
     * @param UserSearch $search
     * @return User[]
     */
    public function search(UserSearch $search): array;

    /**
     * @param int $userId
     * @param User $client
     * @return bool
     */
    public function update(int $userId, User $client): bool;
}