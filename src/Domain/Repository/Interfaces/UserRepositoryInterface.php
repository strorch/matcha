<?php


namespace App\Domain\Repository\Interfaces;


use App\Domain\Entity\User;

interface UserRepositoryInterface
{
    /**
     * Returns boolean result of operation
     *
     * @param User $user
     *
     * @throws \PDOException
     */
    public function create(User $user): void;

    /**
     * @param User $user
     */
    public function update(User $user): void;
}
