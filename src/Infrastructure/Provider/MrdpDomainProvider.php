<?php

declare(strict_types=1);

namespace App\Infrastructure\Provider;

use App\Infrastructure\DB\DB;
use hiqdev\rdap\core\Domain\Entity\Domain;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Infrastructure\Provider\DomainProviderInterface;

final class MrdpDomainProvider implements DomainProviderInterface
{
    private $db;

    public function __construct(array $dbParams)
    {
        $this->db = DB::get($dbParams);
    }

    public function get(DomainName $domainName): Domain
    {
        $domain = new Domain($domainName);
        // TODO: extract data from reader

        return $domain;
    }

    private function execSearchQuery()
    {

    }

    private function saveInfoInFile()
    {

    }
}
