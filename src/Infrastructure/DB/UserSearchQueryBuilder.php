<?php


namespace App\Infrastructure\DB;


use App\Domain\DTO\UserSearch;
use App\Infrastructure\DB\Lib\QueryInterface;

final class UserSearchQueryBuilder implements QueryInterface
{
    public function build(UserSearch $search): string
    {

        return <<<SQL
            SELECT      t1.id,
                        t1.email,
                        t1.username,
                        t1.first_name,
                        t1.last_name
            FROM        users t1
            WHERE       true
            AND         t1.id = :id
            AND         t1.email = :email
            AND         t1.username = :username
            AND         t1.first_name = :first_name
            AND         t1.last_name = :last_name
        SQL;
    }
}
