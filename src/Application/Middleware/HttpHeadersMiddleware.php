<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class HttpHeadersMiddleware implements MiddlewareInterface
{
    private array $headers = [
        'Access-Control-Allow-Origin' => ['*'],
        'Access-Control-Allow-Methods' => ['GET, POST, PUT, PATCH, DELETE, OPTIONS'],
        'Access-Control-Allow-Headers' => ["X-Requested-With, Content-Type, Accept, Origin, Authorization"],
        'Access-Control-Max-Age' => '600',
    ];

    private ResponseFactoryInterface $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getMethod() === 'OPTIONS') {
            return $this->addHeaders($this->responseFactory->createResponse(201));
        }

        $response = $handler->handle($request);

        if (ob_get_contents()) {
            ob_clean();
        }

        return $this->addHeaders($response)->withStatus(200);
    }

    private function addHeaders(ResponseInterface $response)
    {
        foreach ($this->headers as $name => $headers) {
            $response = $response->withHeader($name, $headers);
        }

        return $response;
    }
}
