<?php
declare(strict_types=1);

namespace App\Application\Handler;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpException;
use Slim\Handlers\ErrorHandler as SlimErrorHandler;


class HttpErrorHandler extends SlimErrorHandler
{
    private const DEFAULT_HEADER_STATUS_CODE = 200;
    private const DEFAULT_STATUS_ERROR_CODE = 500;

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
        $statusCode = ($this->exception instanceof HttpException)
                        ? $this->exception->getCode()
                        : self::DEFAULT_STATUS_ERROR_CODE;

        $response = $this->responseFactory->createResponse(self::DEFAULT_HEADER_STATUS_CODE);
        if (headers_sent()) {
            return $response;
        }
        $response->getBody()->write(json_encode(array_filter([
            'statusCode' => $statusCode,
            'error' => $this->exception->getMessage(),
            'trace' => $this->displayErrorDetails ? $this->exception->getTrace() : null,
        ]), JSON_PRETTY_PRINT));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
