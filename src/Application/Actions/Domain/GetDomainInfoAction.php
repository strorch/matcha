<?php
declare(strict_types=1);

namespace App\Application\Actions\Domain;

use App\Infrastructure\Helper\FileHelper;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamFactoryInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Request;

final class GetDomainInfoAction
{
    private $streamFactory;

    public function __construct(StreamFactoryInterface $streamFactory)
    {
        $this->streamFactory = $streamFactory;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        if (empty($args['domainName'])) {
            throw new \BadMethodCallException('Domain name is missing');
        }

        $domainDirName = FileHelper::getHashName(DomainName::of($args['domainName']));
        $desc = file_get_contents(DOMAIN_INFO_DIR . $domainDirName . '/1.json');

        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(200)
            ->withBody($this->streamFactory->createStream((string)$desc));
    }
}
