<?php

namespace App\Exceptions;

use App\Traits\Responses\FailedResponseTrait;
use Exception;

class CustomException extends Exception
{
    use FailedResponseTrait;
    protected $errors;

    protected $message;

    protected $data;

    protected $view;
    private $statusCode;

    public function __construct(int $statusCode, string $message = '', array $errors = [], array $data = [])
    {
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->data = $data;
        $this->errors = $errors;
    }
    public function report()
    {
    }

    public function render($request)
    {
      
    }
    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return string
     */
    public function getMessages(): string
    {
        return $this->message;
    }

    /**
     * @return  mixed
     */
    public function getData(): array
    {
        return $this->data;
    }
}
