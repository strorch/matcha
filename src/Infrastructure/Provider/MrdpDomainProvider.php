<?php

declare(strict_types=1);

namespace App\Infrastructure\Provider;

use App\Infrastructure\DB\DB;
use DateTimeImmutable;
use hiqdev\rdap\core\Domain\Constant\EventAction;
use hiqdev\rdap\core\Domain\Constant\Role;
use hiqdev\rdap\core\Domain\Constant\Status;
use hiqdev\rdap\core\Domain\Entity\Domain;
use hiqdev\rdap\core\Domain\Entity\Entity;
use hiqdev\rdap\core\Domain\Entity\Nameserver;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Domain\ValueObject\Event;
use hiqdev\rdap\core\Domain\ValueObject\Notice;
use hiqdev\rdap\core\Infrastructure\Provider\DomainProviderInterface;
use Iterator;
use JeroenDesloovere\VCard\VCard;

final class MrdpDomainProvider implements DomainProviderInterface// TODO: maybe, add DomainListProviderInterface::getList(): DomainName[]
{
    /**
     * @var DB
     */
    private $db;

    /**
     * MrdpDomainProvider constructor.
     * @param SettingsProviderInterface $settingsProvider
     */
    public function __construct(SettingsProviderInterface $settingsProvider)
    {
        $this->db = DB::get($settingsProvider->getSettingByName('dbParams'));
    }

    /**
     * @return Iterator array of DomainName objects
     */
    public function getAvailableDomainNames(): Iterator
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
        $tmp = new Entity();
        foreach ($this->getContactsInfo($domainId) as $contactInfo) {
            $tmp->addEntity($contactInfo['entity']);
            $eventActor = $contactInfo['eventActor'];
        }
        $domain->addEntity($tmp);
        $domain->addEvent(Event::occurred(EventAction::REGISTRATION(), $eventActor, DateTimeImmutable::createFromFormat('Y-m-d', $searchRes['creation_date'])));
        $domain->addEvent(Event::occurred(EventAction::LAST_CHANGED(), $eventActor, DateTimeImmutable::createFromFormat('Y-m-d', $searchRes['updated_date'])));
        $domain->addEvent(Event::occurred(EventAction::EXPIRATION(), $eventActor, DateTimeImmutable::createFromFormat('Y-m-d', $searchRes['expiration_date'])));
        if (!empty($searchRes['statuses'])) {
            foreach (explode(',', $searchRes['statuses']) as $status) {
                $domain->addStatus(Status::byName(strtoupper($status)));
            }
        }
        if (!empty($searchRes['hosts'])) {
            foreach (explode(',', $searchRes['hosts']) as $host) {
                $domain->addNameserver(new Nameserver(DomainName::of($host)));
            }
        }
        if (!empty($searchRes['site_settings'])) {
            $domain->addNotice(new Notice('Reseller settings', 'settings', [ $searchRes['site_settings'] ]));
        }
        $domain->setPort43(DomainName::of('whois.danesconames.com'));
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
                    o.update_time::date AS updated_date,
                    coalesce(d.created_date,o.create_time)::date AS creation_date,
                    coalesce(d.expires,d.expiration_date,o.create_time+'1year')::date AS expiration_date,
                    e.value as site_settings
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
        LEFT JOIN   value           e ON e.obj_id=c.seller_id   AND e.prop_id=prop_id('reseller_settings:thesite')
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
     * @return Iterator wich is an Entity[]
     */
    private function getContactsInfo(string $domainId): Iterator
    {
        $contacts = $this->db->query("
            SELECT  dc.type_id as role_type_id,
                    CASE WHEN dc.type = 'admin' THEN 'registrar'
                         WHEN dc.type = 'tech'  THEN 'technical'
                         ELSE dc.type
                    END     AS role_type,
                    zc.*
            FROM    domain2contactz dc
            JOIN    zcontact        zc  ON  zc.obj_id = dc.contact_id
                                        AND dc.domain_id = :domain_id
        ", [':domain_id' => $domainId]);
        foreach ($contacts as $contact) {
            $entity = new Entity();
            $entity->addVcard($this->getVCard($contact));
            $entity->addRole(Role::byName(strtoupper($contact['role_type'])));
            yield [
                'entity' => $entity,
                'eventActor' => $contact['name'],
            ];
        }
    }

    /**
     * @param mixed[] $cInfo
     * @return VCard
     */
    private function getVCard(array $cInfo): VCard
    {
        $contactVCard = new VCard();
        $contactVCard->addRole(Role::byName(strtoupper($cInfo['role_type'])));
        $contactVCard->addEmail($cInfo['email']);
        $contactVCard->addEmail($cInfo['abuse_email']);
        $contactVCard->addPhoneNumber($cInfo['phone']);
        $contactVCard->addBirthday($cInfo['birth_date']);
        $contactVCard->addName($cInfo['last_name'], $cInfo['first_name']);
        $contactVCard->addAddress('', '', $cInfo['street1'], $cInfo['city'], $cInfo['province'], $cInfo['postal_code'], $cInfo['country']);
        $contactVCard->addAddress('', '', $cInfo['street2'], $cInfo['city'], $cInfo['province'], $cInfo['postal_code'], $cInfo['country']);
        $contactVCard->addAddress('', '', $cInfo['street3'], $cInfo['city'], $cInfo['province'], $cInfo['postal_code'], $cInfo['country']);
        $contactVCard->addCompany($cInfo['organization']);
        return $contactVCard;
    }
}
