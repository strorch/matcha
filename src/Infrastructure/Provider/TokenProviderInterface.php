<?php


namespace App\Infrastructure\Provider;


use App\Domain\Entity\User;

interface TokenProviderInterface
{
    public function saveUser(User $token): string;

    public function find(string $hash): User;

    public function remove(string $hash): void;
}
