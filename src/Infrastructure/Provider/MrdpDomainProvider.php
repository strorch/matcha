<?php

declare(strict_types=1);

namespace App\Infrastructure\Provider;

use App\Infrastructure\DB\DB;
use hiqdev\rdap\core\Domain\Entity\Domain;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Infrastructure\Provider\DomainProviderInterface;

final class MrdpDomainProvider implements DomainProviderInterface
{
    /**
     * @var DB
     */
    private $db;

    /**
     * MrdpDomainProvider constructor.
     * @param array $dbParams
     */
    public function __construct(array $dbParams)
    {
        $this->db = DB::get($dbParams);
    }

    /**
     * @param DomainName $domainName
     * @return Domain
     */
    public function get(DomainName $domainName): Domain
    {
        $domain = new Domain($domainName);
        $tmp = $this->db->query('select * from client2role limit 1');
        $domain->setHandle(reset($tmp)['role']);
        // TODO: extract data from reader

        return $domain;
    }

    private function prepareCondition()
    {
        //TODO implement prepareCondition method
    }
}
