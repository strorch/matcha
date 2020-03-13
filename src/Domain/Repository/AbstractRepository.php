<?php


namespace App\Domain\Repository;


use App\Infrastructure\DB\DB;

abstract class AbstractRepository
{
    /**
     * @var DB
     */
    protected $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }
}