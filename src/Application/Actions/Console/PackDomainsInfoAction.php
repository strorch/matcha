<?php
declare(strict_types=1);

namespace App\Application\Actions\Console;

use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Infrastructure\Provider\DomainProviderInterface;
use hiqdev\rdap\core\Infrastructure\Serialization\SerializerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\NonBufferedBody;
use Slim\Psr7\Request;

final class PackDomainsInfoAction
{
    /**
     * @var DomainProviderInterface
     */
    private $domainProvider;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(DomainProviderInterface $domainProvider, SerializerInterface $serializer)
    {
        $this->domainProvider = $domainProvider;
        $this->serializer = $serializer;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $domain = $this->domainProvider->get(DomainName::of('example.com'));
        $serialized = $this->serializer->serialize($domain);

        //TODO: insert into files

        return $response
            ->withStatus(200)
            ->withBody(new NonBufferedBody());
    }
}
