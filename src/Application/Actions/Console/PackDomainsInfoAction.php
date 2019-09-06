<?php
declare(strict_types=1);

namespace App\Application\Actions\Console;

use App\Infrastructure\Provider\MrdpDomainProvider;
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
     * @param MrdpDomainProvider $domainProvider
     * @param SerializerInterface $serializer
     * @param StreamFactoryInterface $streamFactory
     */
    public function __construct(MrdpDomainProvider $domainProvider, SerializerInterface $serializer, StreamFactoryInterface $streamFactory)
    {
        $this->domainProvider = $domainProvider;
        $this->serializer = $serializer;
        $this->streamFactory = $streamFactory;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $availableNames = $this->domainProvider->getAvailableDomainNames();
//        foreach ($availableNames as $name) {
            $domain = $this->domainProvider->get(DomainName::of(reset($availableNames)['name']));
            $serialized = $this->serializer->serialize($domain);
//        }

        return $response
            ->withStatus(200)
            ->withBody($this->streamFactory->createStream($serialized));
    }


    private function saveDomainInfoInFile()
    {
        //TODO implement saveDomainInfoInFile method
    }
}
