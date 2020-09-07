<?php


namespace App\Infrastructure\DB\Lib;


interface QueryInterface
{
    public function build(): string;
}
