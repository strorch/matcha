<?php


namespace App\Domain\Repository;


use App\Domain\DTO\ClientSearch;
use App\Domain\Repository\Interfaces\ClientRepositoryInterface;
use App\Infrastructure\DB\DB;

class ClientRepository implements ClientRepositoryInterface
{
    /**
     * @var DB
     */
    private $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function create(Client $client): bool
    {
        return true;
    }

    public function search(ClientSearch $search): array
    {
        return [];
    }
}