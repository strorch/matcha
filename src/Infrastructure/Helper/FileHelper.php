<?php


namespace App\Infrastructure\Helper;


use hiqdev\rdap\core\Domain\ValueObject\DomainName;

class FileHelper
{
    public static function getDomainNameHash(DomainName $domainName): string
    {
        return md5($domainName->toLDH());
    }
}
