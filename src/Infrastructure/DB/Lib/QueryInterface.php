<?php


namespace App\Infrastructure\DB\Lib;


use App\Domain\DTO\UserSearch;

interface QueryInterface
{
    public function build(UserSearch $search): string;
}
