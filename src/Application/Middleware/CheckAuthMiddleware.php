<?php


namespace App\Application\Middleware;


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CheckAuthMiddleware extends AbstractAccessMiddleware
{
    /**
     * @inheritDoc
     */
    protected function checkAccess(ServerRequestInterface $request, RequestHandlerInterface $handler): bool
    {
//        return !empty($this->session->get('user'));
        return true;
    }
}
