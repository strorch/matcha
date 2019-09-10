<?php
declare(strict_types=1);

namespace App\Application\Actions\Console;

use App\Infrastructure\Helper\FileHelper;
use App\Infrastructure\Provider\MrdpDomainProvider;
use App\Infrastructure\Provider\SettingsProvider;
use App\Infrastructure\Provider\SettingsProviderInterface;
use hiqdev\rdap\core\Domain\Entity\Domain;
use hiqdev\rdap\core\Infrastructure\Exception\ObjectNotAvailableException;
use hiqdev\rdap\core\Infrastructure\Provider\DomainProviderInterface;
use hiqdev\rdap\core\Infrastructure\Serialization\SerializerInterface;
use League\Uri\File;
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
     * @var SettingsProviderInterface
     */
    private $settingsProvider;

    /**
     * PackDomainsInfoAction constructor.
     * @param MrdpDomainProvider $domainProvider
     * @param SerializerInterface $serializer
     * @param StreamFactoryInterface $streamFactory
     * @param SettingsProviderInterface $settingsProvider
     */
    public function __construct(
        MrdpDomainProvider $domainProvider,
        SerializerInterface $serializer,
        StreamFactoryInterface $streamFactory,
        SettingsProviderInterface $settingsProvider
    ) {
        $this->domainProvider = $domainProvider;
        $this->serializer = $serializer;
        $this->streamFactory = $streamFactory;
        $this->settingsProvider = $settingsProvider;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws ObjectNotAvailableException
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $availableNames = $this->domainProvider->getAvailableDomainNames();
        foreach ($availableNames as $key => $name) {
            if ($key >= 15)
                break;
            $domain = $this->domainProvider->get($availableNames->current());
            $serialized = $this->serializer->serialize($domain);
            $this->saveDomainInfoInFile($domain, $serialized);
        }

        return $response
            ->withStatus(200)
            ->withBody(new NonBufferedBody());
//        return $response
//            ->withStatus(200)
//            ->withBody($this->streamFactory->createStream($serialized));
    }


    private function saveDomainInfoInFile(Domain $domain, string $serialized): void
    {
        $domainInfoDir = $this->settingsProvider->getSettingByName('domainInfoDir');
        FileHelper::createPathToFile($domain, $domainInfoDir);
        file_put_contents(FileHelper::getPathToDomainFile((string)$domain->getLdhName(), $domainInfoDir), $serialized);
    }
}
