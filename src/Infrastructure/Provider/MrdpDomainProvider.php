<?php

declare(strict_types=1);

namespace App\Infrastructure\Provider;

use App\Infrastructure\DB\DB;
use hiqdev\rdap\core\Domain\Entity\Domain;
use hiqdev\rdap\core\Domain\Entity\Entity;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Infrastructure\Provider\DomainProviderInterface;

final class MrdpDomainProvider implements DomainProviderInterface// TODO: maybe, add DomainListProviderInterface::getList(): DomainName[]
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
     * @return \Iterator array of DomainName objects
     */
    public function getAvailableDomainNames(): \Iterator
    {
        $domains = $this->db->query("
            SELECT      d.domain as name
            FROM        domain              d
            LEFT JOIN   status              s ON s.object_id=d.obj_id AND s.type_id=status_id('domain,whoised')
            WHERE       d.state_id!=state_id('domain,new')
            ORDER BY    s.time IS NOT NULL,s.time ASC
        ");
        foreach ($domains as $domain) {
            yield DomainName::of($domain['name']);
        }
    }

    /**
     * @param DomainName $domainName
     * @return Domain
     */
    public function get(DomainName $domainName): Domain
    {
        $domain = new Domain($domainName);
        $searchRes = $this->prepareCondition((string)$domainName);
        $domainId = (string)$searchRes['obj_id'];
        $domain->setHandle($domainId);

        foreach ($this->getEntities($domainId) as $entity) {
            $domain->addEntity($entity);
        }

        return $domain;
    }

    private function prepareCondition(string $name)
    {
        $commonInfo = $this->db->query("
        SELECT      DISTINCT 
                    d.obj_id,
                    d.roid,
                    d.domain,
                    h.hosts,
                    s.statuses,
                    to_t(whois_protected) AS whois_protected,
                    to_t(is_holded) AS is_holded,
                    to_t(d.state_id IN (state_id('domain,deleted'),
                    state_id('domain,new'))) AS deleted,
                    coalesce(r.value,t.value,w.value) AS through,
                    coalesce(u.value,a.value,b.value) AS abusemail,
                    y.value AS dnssec_enabled,
                    o.update_time AS updated_date,
                    coalesce(d.created_date,o.create_time)::date AS creation_date,
                    coalesce(d.expires,d.expiration_date,o.create_time+'1year')::date AS expiration_date
        FROM        domainz         d
        JOIN        obj             o ON o.obj_id=d.obj_id
                                     AND d.domain=:name
        LEFT JOIN   domain_hosts    h ON h.domain_id=d.obj_id
        LEFT JOIN   client          c ON c.obj_id=d.client_id
        LEFT JOIN   value           r ON r.obj_id=d.obj_id      AND r.prop_id=prop_id('domain,options:registered_through')
        LEFT JOIN   value           u ON u.obj_id=d.obj_id      AND u.prop_id=prop_id('domain,options:abuse_email')
        LEFT JOIN   value           y ON y.obj_id=d.obj_id      AND y.prop_id=prop_id('domain,options:dnssec_enabled')
        LEFT JOIN   value           t ON t.obj_id=c.obj_id      AND t.prop_id=prop_id('reseller_settings:checked_whois_regthrough')
        LEFT JOIN   value           w ON w.obj_id=c.seller_id   AND w.prop_id=prop_id('reseller_settings:checked_whois_regthrough')
        LEFT JOIN   value           a ON a.obj_id=c.obj_id      AND a.prop_id=prop_id('reseller_settings:whois_abusemail')
        LEFT JOIN   value           b ON b.obj_id=c.seller_id   AND b.prop_id=prop_id('reseller_settings:whois_abusemail')
        LEFT JOIN   (
            SELECT      s.object_id,cjoin(t.name) AS statuses
            FROM        status          s
            JOIN        ref             t ON t.obj_id=s.type_id AND t._id=status_id('domain,epp')
            GROUP BY    s.object_id
        )           AS              s ON s.object_id=d.obj_id
        ", [':name' => $name]);

        return reset($commonInfo);
    }

    /**
     * @param string $domainId
     * @return Entity[]
     */
    private function getEntities(string $domainId): array
    {
        $contacts = $this->db->query("
            SELECT  dc.type_id,
                    CASE WHEN dc.type = 'admin' THEN 'registrar'
                         WHEN dc.type = 'tech'  THEN 'technical'
                         ELSE dc.type
                    END     AS type,
                    zc.*
            FROM    domain2contactz dc
            JOIN    zcontact        zc  ON  zc.obj_id = dc.contact_id
                                        AND dc.domain_id = :domain_id
        ", [':domain_id' => $domainId]);
        foreach ($contacts as $contact) {
            //TODO: compact entities
        }
        return [];
    }
}
