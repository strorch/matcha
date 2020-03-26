<?php


namespace App\Application\Middleware;


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CheckGuestMiddleware extends AbstractAccessMiddleware
{
    /**
     * @inheritDoc
     */
    protected function checkAccess(ServerRequestInterface $request, RequestHandlerInterface $handler): bool
    {
        return true;
//        return empty($this->session->get('user'));
    }
}
