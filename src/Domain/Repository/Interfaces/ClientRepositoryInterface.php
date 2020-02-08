<?php


namespace App\Domain\Repository\Interfaces;


use App\Domain\Repository\Client;

interface ClientRepositoryInterface
{
    public function create(Client $client): bool;
}