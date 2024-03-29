<?php

namespace Stark\Framework\Exception;

class BadRequestHttpException extends HttpException
{
    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        parent::__construct(400, $message, $previous, array(), $code);
    }
}