<?php


namespace App\Application\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class JSONSerializeMiddleware implements MiddlewareInterface
{
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $oldResponse = (string)$handler->handle($request)->getBody();

        $response = new Response();
        $response->getBody()->write('aga');
        $response->getBody()->write($oldResponse);
        $response->getBody()->write('kakaka');

        return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
    }
}