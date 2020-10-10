<?php
declare(strict_types=1);

namespace App\Application\Handlers;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpException;
use Slim\Handlers\ErrorHandler as SlimErrorHandler;


class HttpErrorHandler extends SlimErrorHandler
{
    public function setDisplayErrorDetailsFlag(bool $displayErrorDetails): void
    {
        $this->displayErrorDetails = $displayErrorDetails;
    }

    public function getDisplayErrorDetailsFlag(): bool
    {
        return $this->displayErrorDetails;
    }

    protected function respond(): Response
    {
        $exception = $this->exception;
        $statusCode = 500;

        if ($exception instanceof HttpException) {
            $statusCode = $exception->getCode();
        }

        $response = $this->responseFactory->createResponse($statusCode);
        $response->getBody()->write(json_encode(array_filter([
            'statusCode' => $statusCode,
            'error' => $this->exception->getMessage(),
            'trace' => $this->displayErrorDetails ? $this->exception->getTrace() : null,
        ]), JSON_PRETTY_PRINT));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
