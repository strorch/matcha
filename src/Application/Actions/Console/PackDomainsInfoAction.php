<?php
declare(strict_types=1);

namespace App\Application\Actions\Console;

use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Infrastructure\Provider\DomainProviderInterface;
use hiqdev\rdap\core\Infrastructure\Serialization\SerializerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamFactoryInterface;
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
    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;

    /**
     * PackDomainsInfoAction constructor.
     * @param DomainProviderInterface $domainProvider
     * @param SerializerInterface $serializer
     * @param StreamFactoryInterface $streamFactory
     */
    public function __construct(DomainProviderInterface $domainProvider, SerializerInterface $serializer, StreamFactoryInterface $streamFactory)
    {
        $this->domainProvider = $domainProvider;
        $this->serializer = $serializer;
        $this->streamFactory = $streamFactory;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $domain = $this->domainProvider->get(DomainName::of('example.com'));
        $serialized = $this->serializer->serialize($domain);

        //TODO: insert into files

        return $response
            ->withStatus(200)
            ->withBody($this->streamFactory->createStream($serialized));
    }
}
