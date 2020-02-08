<?php
declare(strict_types=1);

namespace App\Application\Actions\Auth;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamFactoryInterface;
use Slim\Psr7\Request;

final class LoginAction
{
    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;

    /**
     * GetDomainInfoAction constructor.
     * @param StreamFactoryInterface $streamFactory
     */
    public function __construct(StreamFactoryInterface $streamFactory)
    {
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $response
            ->withBody($this->streamFactory->createStream('success'));
    }
}
