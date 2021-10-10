<?php


namespace App\Domain\Repository;


use App\Domain\Repository\Interfaces\InterestRepositoryInterface;
use App\Domain\ValueObject\Interest;
use App\Domain\ValueObject\InterestsSearch;

final class InterestRepository implements InterestRepositoryInterface
{

    public function all(): array
    {
        // TODO: Implement all() method.
    }

    public function search(InterestsSearch $interest): array
    {
        // TODO: Implement search() method.
    }

    public function create(Interest $interest): void
    {
        // TODO: Implement create() method.
    }
}
