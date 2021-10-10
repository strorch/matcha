<?php
declare(strict_types=1);

namespace App\Infrastructure\Validator;

use Exception;
use Throwable;

class ValidatorException extends Exception
{
    private string $attribute;

    public function __construct(string $attribute, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->attribute = $attribute;
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }
}
