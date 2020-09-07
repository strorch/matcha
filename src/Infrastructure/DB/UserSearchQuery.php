<?php


namespace App\Infrastructure\DB;


use App\Domain\ValueObject\UserSearch;
use App\Infrastructure\DB\Lib\QueryInterface;

final class UserSearchQuery implements QueryInterface
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

        // TODO create UserSearchQuery and work with it
        $res = $this->db->query(<<<SQL
            SELECT 
            FROM        users t1
            WHERE       t1.username = :username
            AND         check_password(:password, )
        SQL, [
        ]);
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
