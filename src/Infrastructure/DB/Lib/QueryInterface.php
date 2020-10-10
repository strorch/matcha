<?php


namespace App\Infrastructure\DB\Lib;


use App\Domain\ValueObject\UserSearch;

interface QueryInterface
{
    public function build(UserSearch $search): string;
}
