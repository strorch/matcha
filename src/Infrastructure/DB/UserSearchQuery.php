<?php


namespace App\Infrastructure\DB;


use App\Domain\ValueObject\UserSearch;
use App\Infrastructure\DB\Lib\QueryInterface;

final class UserSearchQuery implements QueryInterface
{
    public function __construct()
    {
    }

    public function build(UserSearch $search): string
    {

        // TODO create UserSearchQuery and work with it
        return <<<SQL
            SELECT 
            FROM        users t1
            WHERE       t1.username = :username
            AND         check_password(:password, )
        SQL;
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
