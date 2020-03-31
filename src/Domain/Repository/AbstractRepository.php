<?php


namespace App\Domain\Repository;


use App\Domain\Repository\Interfaces\UserRepositoryInterface;
use App\Infrastructure\DB\DB;

abstract class AbstractRepository implements UserRepositoryInterface
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
