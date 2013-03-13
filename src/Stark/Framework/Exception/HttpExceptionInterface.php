<?php

namespace Stark\Framework\Exception;

interface HttpExceptionInterface
{
    public function getStatusCode();
    public function getHeaders();
}