<?php


namespace App\Domain\Repository\Interfaces;


use App\Domain\DTO\UserSearch;
use App\Domain\Repository\User;

interface UserRepositoryInterface
{
    public function create(User $client): bool;

    public function search(UserSearch $search): array;
}