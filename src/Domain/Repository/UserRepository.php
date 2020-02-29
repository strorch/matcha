<?php


namespace App\Domain\Repository;


use App\Domain\DTO\UserSearch;
use App\Domain\Repository\Interfaces\UserRepositoryInterface;
use App\Infrastructure\DB\DB;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var DB
     */
    private $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

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
}