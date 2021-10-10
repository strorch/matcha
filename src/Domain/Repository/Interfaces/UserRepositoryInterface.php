<?php


namespace App\Domain\Repository\Interfaces;


use App\Domain\Entity\User;
use App\Infrastructure\Provider\UserProviderInterface;

interface UserRepositoryInterface extends UserProviderInterface
{
    public function create(User $user): void;

    public function update(User $user): void;
}
