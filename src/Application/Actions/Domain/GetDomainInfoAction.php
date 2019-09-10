<?php
declare(strict_types=1);

namespace App\Application\Actions\Domain;

use App\Infrastructure\Helper\FileHelper;
use App\Infrastructure\Provider\SettingsProviderInterface;
use BadMethodCallException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamFactoryInterface;
use Slim\Psr7\Request;

final class GetDomainInfoAction
{
    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;

    /**
     * @var SettingsProviderInterface $settingsProvider
     */
    private $settingsProvider;

    /**
     * GetDomainInfoAction constructor.
     * @param StreamFactoryInterface $streamFactory
     * @param SettingsProviderInterface $settingsProvider
     */
    public function __construct(StreamFactoryInterface $streamFactory, SettingsProviderInterface $settingsProvider)
    {
        $this->streamFactory = $streamFactory;
        $this->settingsProvider = $settingsProvider;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        if (empty($args['domainName'])) {
            throw new BadMethodCallException('Domain name is missing');
        }
        $domainInfoDir = $this->settingsProvider->getSettingByName('domainInfoDir');
        $pathToDomainFile = FileHelper::getPathToDomainFile($args['domainName'], $domainInfoDir);
        if (!file_exists($pathToDomainFile)) {
            return $response->withHeader('Content-Type', 'application/json')
                ->withStatus(418)
                ->withBody($this->streamFactory->createStream($this->getErrorMessage()));
        }

        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(200)
            ->withBody($this->streamFactory->createStreamFromFile($pathToDomainFile, 'r+'));
    }

    /**
     * @return string
     */
    private function getErrorMessage(): string
    {
        return json_encode([
            'errorCode' => 418,
            'title' => 'Your Beverage Choice is Not Available',
            'description' => [
                'domain does not exist',
            ],
        ]);
    }
}
