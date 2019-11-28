<?php


namespace Lwj\Rbac\Exceptions;


use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class UniqueException extends HttpException
{
    public function __construct(string $message = null, Throwable $previous = null, array $headers = [], ?int $code = 0)
    {
        parent::__construct(422, $message, $previous, $headers, $code);
    }
}
