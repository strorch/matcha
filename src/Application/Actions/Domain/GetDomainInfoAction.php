<?php
declare(strict_types=1);

namespace App\Application\Actions\Domain;

use App\Infrastructure\Helper\FileHelper;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
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
     * @var string $domainInfoDir
     */
    private $domainInfoDir;

    /**
     * GetDomainInfoAction constructor.
     * @param StreamFactoryInterface $streamFactory
     * @param string $domainInfoDir
     */
    public function __construct(StreamFactoryInterface $streamFactory, string $domainInfoDir)
    {
        $this->streamFactory = $streamFactory;
        $this->domainInfoDir = $domainInfoDir;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        if (empty($args['domainName'])) {
            throw new \BadMethodCallException('Domain name is missing');
        }
        $pathToDomain = FileHelper::getPathToDomain($args['domainName'], $this->domainInfoDir);
        if (!file_exists($pathToDomain)) {
            return $response->withHeader('Content-Type', 'application/json')
                ->withStatus(418)
                ->withBody($this->streamFactory->createStream($this->getErrorMessage()));
        }

        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(200)
            ->withBody($this->streamFactory->createStreamFromFile($pathToDomain, 'r+'));
    }

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
