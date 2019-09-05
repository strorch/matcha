<?php


namespace App\Infrastructure\Helper;


use hiqdev\rdap\core\Domain\ValueObject\DomainName;

class FileHelper
{
    public static function getHashName(DomainName $domainName): string
    {
        return hash('md5', $domainName->toLDH());
    }
}
