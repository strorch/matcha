<?php


namespace App\Domain\Repository;


use App\Infrastructure\DB\Lib\DB;

abstract class AbstractRepository
{
    private DB $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function getDb(): DB
    {
        return $this->db;
    }
}
