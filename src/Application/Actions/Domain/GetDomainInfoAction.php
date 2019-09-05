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

        $domainDirName = FileHelper::getDomainNameHash(DomainName::of($args['domainName']));
        $desc = file_get_contents($this->domainInfoDir . $domainDirName . '/1.json');

        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(200)
            ->withBody($this->streamFactory->createStream((string)$desc));
    }

//    private function
}
