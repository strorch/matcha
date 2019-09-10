<?php


namespace App\Infrastructure\Helper;


use hiqdev\rdap\core\Domain\Entity\Domain;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;

final class FileHelper
{
    /**
     * @param DomainName $domainName
     * @return string
     */
    public static function getDomainNameHash(DomainName $domainName): string
    {
        return md5($domainName->toLDH());
    }

    /**
     * @param string $domainName
     * @param string $domainInfoDir
     * @return string
     */
    public static function getPathToDomainDir(string $domainName, string $domainInfoDir): string
    {
        $hash = static::getDomainNameHash(DomainName::of($domainName));
        $fileLocation = "$hash[0]/$hash[1]";
        return $domainInfoDir . $fileLocation;
    }
    /**
     * @param string $domainName
     * @param string $domainInfoDir
     * @return string
     */
    public static function getPathToDomainFile(string $domainName, string $domainInfoDir): string
    {
        $pathToDomainDir = static::getPathToDomainDir($domainName, $domainInfoDir);
        return $pathToDomainDir . "/$domainName.json";
    }

    /**
     * @param Domain $name
     * @param string $domainInfoDir
     */
    public static function createPathToFile(Domain $name, string $domainInfoDir): void
    {
        $domainName = $name->getLdhName();
        $pathToDomain = static::getPathToDomainDir($domainName, $domainInfoDir);
        if (!is_dir($pathToDomain)) {
            mkdir($pathToDomain, 0755, true);
        }
    }
}
