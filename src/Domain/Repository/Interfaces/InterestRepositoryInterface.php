<?php


namespace App\Domain\Repository\Interfaces;


use App\Domain\ValueObject\Interest;
use App\Domain\ValueObject\InterestsSearch;

interface InterestRepositoryInterface
{
    public function all(): array;

    public function search(InterestsSearch $interest): array;

    public function create(Interest $interest): void;
}
