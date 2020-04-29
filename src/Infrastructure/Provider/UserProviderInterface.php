<?php


namespace App\Infrastructure\Provider;


use App\Domain\Entity\User;
use App\Domain\ValueObject\UserSearch;

interface UserProviderInterface
{
    /**
     * Returns a search result which is a array of [[User]] entities
     * @see User
     *
     * @param UserSearch $search
     * @return User[]
     */
    public function search(UserSearch $search): array;
}
