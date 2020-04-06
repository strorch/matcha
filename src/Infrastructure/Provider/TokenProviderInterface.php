<?php


namespace App\Infrastructure\Provider;


use App\Domain\Entity\User;

interface TokenProviderInterface
{
    /**
     * @param User $token
     * @return string
     */
    public function saveUser(User $token): string;

    /**
     * @param string $hash
     * @return User
     */
    public function find(string $hash): User;

    /**
     * @param string $hash
     */
    public function remove(string $hash): void;
}
