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
     * @return array|null
     */
    public function getAvailableDomainNames()
    {
        return $this->db->query('
            SELECT      d.domain as name
            FROM        domain              d
            LEFT JOIN   status              s ON s.object_id=d.obj_id AND s.type_id=status_id(\'domain,whoised\')
            ORDER BY    s.time IS NOT NULL,s.time ASC
        ');
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

        return $domain;
    }

    private function prepareCondition()
    {
        //TODO implement prepareCondition method
    }
}
