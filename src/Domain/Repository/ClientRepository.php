<?php


namespace App\Domain\Repository;


use App\Domain\Repository\Interfaces\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{
    public function create(Client $client): bool
    {
        return true;
    }
}