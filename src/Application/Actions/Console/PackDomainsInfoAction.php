<?php
declare(strict_types=1);

namespace App\Application\Actions\Console;

use App\Infrastructure\Provider\SettingsProviderInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamFactoryInterface;
use Slim\Psr7\NonBufferedBody;
use Slim\Psr7\Request;

final class PackDomainsInfoAction
{
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
     * @param StreamFactoryInterface $streamFactory
     * @param SettingsProviderInterface $settingsProvider
     */
    public function __construct(
        StreamFactoryInterface $streamFactory,
        SettingsProviderInterface $settingsProvider
    ) {
        $this->streamFactory = $streamFactory;
        $this->settingsProvider = $settingsProvider;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        return $response
            ->withStatus(200)
            ->withBody(new NonBufferedBody());
    }
}
