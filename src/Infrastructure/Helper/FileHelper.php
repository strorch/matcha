<?php


namespace App\Infrastructure\Helper;


use hiqdev\rdap\core\Domain\ValueObject\DomainName;

final class FileHelper
{
    public static function getDomainNameHash(DomainName $domainName): string
    {
        return md5($domainName->toLDH());
    }

    public static function getPathToDomain(string $domainName, string $domainInfoDir): string
    {
        $hash = static::getDomainNameHash(DomainName::of($domainName));
        $fileLocation = "$hash[0]/$hash[1]/$domainName.json";
        return $domainInfoDir . $fileLocation;
    }
}
