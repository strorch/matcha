<?php


namespace App\Domain\Repository\Interfaces;


use App\Domain\DTO\ClientSearch;
use App\Domain\Repository\Client;

interface ClientRepositoryInterface
{
    public function create(Client $client): bool;

    public function search(ClientSearch $search): array;
}