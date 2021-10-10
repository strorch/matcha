<?php
declare(strict_types=1);

namespace App\Application\Handler;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\ResponseEmitter;

class ShutdownHandler
{
    private Request $request;
    private HttpErrorHandler $errorHandler;

    public function __construct(
        Request $request,
        HttpErrorHandler $errorHandler
    ) {
        $this->request = $request;
        $this->errorHandler = $errorHandler;
    }

    public function __invoke()
    {
        $error = error_get_last();
        if (empty($error)) {
            return;
        }

        $errorFile = $error['file'];
        $errorLine = $error['line'];
        $errorMessage = $error['message'];
        $errorType = $error['type'];
        $message = 'An error while processing your request. Please try again later.';

        if ($this->errorHandler->getDisplayErrorDetailsFlag()) {
            switch ($errorType) {
                case E_ERROR:
                    $message = "FATAL ERROR: {$errorMessage}. ";
                    $message .= " on line {$errorLine} in file {$errorFile}.";
                    break;

                case E_WARNING:
                    $message = "WARNING: {$errorMessage}";
                    break;

                case E_NOTICE:
                    $message = "NOTICE: {$errorMessage}";
                    break;

                default:
                    $message = "ERROR: {$errorMessage}";
                    $message .= " on line {$errorLine} in file {$errorFile}.";
                    break;
            }
        }

        $exception = new HttpInternalServerErrorException($this->request, $message);
        $response = $this->errorHandler->__invoke(
            $this->request,
            $exception,
            $this->errorHandler->getDisplayErrorDetailsFlag(),
            false,
            false
        );

        if (ob_get_length()) {
            ob_clean();
        }
        $responseEmitter = new ResponseEmitter();
        $responseEmitter->emit($response);
    }
}
