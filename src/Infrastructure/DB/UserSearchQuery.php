<?php


namespace App\Infrastructure\DB;


use App\Domain\ValueObject\UserSearch;

final class UserSearchQuery
{
    /**
     * @var UserSearch
     */
    private UserSearch $search;

    public function __construct(UserSearch $search)
    {
        $this->search = $search;
    }

    public function build(): string
    {

    }

    private function getSelect(): string
    {

    }

    private function getJoin(): string
    {

    }

    private function getWhere(): string
    {

    }
}
