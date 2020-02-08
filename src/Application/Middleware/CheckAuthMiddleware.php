<?php


namespace App\Application\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class CheckAuthMiddleware implements MiddlewareInterface
{
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

        return $response;
    }
}