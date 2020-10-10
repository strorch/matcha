<?php


namespace App\Domain\Repository\Interfaces;


use App\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function create(User $user): void;

    public function update(User $user): void;

    public function search(User $user): void;

    public function delete(User $user): void;
}
