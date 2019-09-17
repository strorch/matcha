<?php
declare(strict_types=1);

namespace App\Application\Actions\Domain;

use App\Infrastructure\Provider\SettingsProviderInterface;
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
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(200)
            ->withBody($this->streamFactory->createStream('success'));
    }
}
