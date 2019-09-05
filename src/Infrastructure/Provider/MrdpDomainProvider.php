<?php

declare(strict_types=1);

namespace App\Infrastructure\Provider;

use hiqdev\rdap\core\Domain\Entity\Domain;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Infrastructure\Provider\DomainProviderInterface;

final class MrdpDomainProvider implements DomainProviderInterface
{
    public function __construct()
    {
        // TODO: DB connect or File reader
    }

    public function get(DomainName $domainName): Domain
    {
        $domain = new Domain($domainName);
        // TODO: extract data from reader

        return $domain;
    }
}
