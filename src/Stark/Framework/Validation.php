<?php

namespace Stark\Framework;

use Stark\Framework\Exception\InvalidParameter;

class Validation
{
    public function isBoolean($var)
    {
        if (!filter_var($var, FILTER_VALIDATE_BOOLEAN)) {
            throw new InvalidParameter("'$var' is not a valid boolean");
        }

        return $var;
    }

    public function isInteger($var)
    {
        if (!filter_var($var, FILTER_VALIDATE_INT)) {
            throw new InvalidParameter("'$var' is not a valid int");
        }

        return $var;
    }

    public function isFloat($var)
    {
        if (!filter_var($var, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_THOUSAND)) {
            throw new InvalidParameter("'$var' is not a valid float");
        }

        return $var;
    }

    public function isNumber($var)
    {
        if (!filter_var($var, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[0-9]+$/')))) {
            throw new InvalidParameter("'$var' is not a valid number");
        }

        return $var;
    }

    public function isEmail($var)
    {
        if (!filter_var($var, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidParameter("'$var' is not a valid email");
        }

        return $var;
    }

    public function isUrl($var)
    {
        if (!filter_var($var, FILTER_VALIDATE_URL)) {
            throw new InvalidParameter("'$var' is not a valid URL");
        }

        return $var;
    }

    public function isAlphanumeric($var)
    {
        if (!filter_var($var, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[a-zA-Z0-9]+$/')))) {
            throw new InvalidParameter("'$var' is not a valid alphanumeric value");
        }

        return $var;
    }

    public function isAlpha($var)
    {
        if (!filter_var($var, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[a-zA-Z]+$/')))) {
            throw new InvalidParameter("'$var' is not a valid alpha value");
        }

        return $var;
    }

    public function isString($var)
    {
        if (!filter_var($var, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[a-zA-Z0-9._-\s]+$/')))) {
            throw new InvalidParameter("'$var' is not a valid string");
        }

        return $var;
    }

    public function isNotBlank($var)
    {
        if ($var === '') {
            throw new InvalidParameter("'$var' is blank");
        }

        return $var;
    }

    public function sanitizeInteger($var)
    {
        return filter_var($var, FILTER_SANITIZE_NUMBER_INT);
    }

    public function sanitizeFloat($var)
    {
        return filter_var($var, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_THOUSAND | FILTER_FLAG_ALLOW_FRACTION);
    }

    public function sanitizeEmail($var)
    {
        return filter_var($var, FILTER_SANITIZE_EMAIL);
    }

    public function sanitizeUrl($var)
    {
        return filter_var($var, FILTER_SANITIZE_URL);
    }

    public function sanitizeString($var)
    {
        return filter_var($var, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH | FILTER_FLAG_ENCODE_LOW);
    }
}