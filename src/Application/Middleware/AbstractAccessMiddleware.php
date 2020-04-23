<?php


namespace App\Application\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

abstract class AbstractAccessMiddleware implements MiddlewareInterface
{
    /**
     * @var SessionInterface
     */
    protected SessionInterface $session;

    /**
     * @var StreamFactoryInterface
     */
    protected StreamFactoryInterface $streamFactory;

    public function __construct(SessionInterface $session, StreamFactoryInterface $streamFactory)
    {
        $this->session = $session;
        $this->streamFactory = $streamFactory;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return bool
     */
    abstract protected function checkAccess(ServerRequestInterface $request, RequestHandlerInterface $handler): bool;

    /**
     * @inheritDoc
     */
    final public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->checkAccess($request, $handler)) {
            return $handler->handle($request);
        }

        return (new Response())
            ->withBody($this->streamFactory->createStream('{"error": "Not allowed"}'))
            ->withStatus(403);
    }
}
