<?php

namespace Stark\Framework\Tests;

use Stark\Framework\Validation;

class ValidationTest extends \PHPUnit_Framework_Testcase
{
    protected $validation;

    public function setUp()
    {
        $this->validation = new Validation;
    }

    /**
     * @expectedException Stark\Framework\Exception\InvalidParameter
     */
    public function testIsValidatingBoolean()
    {
        $this->validation->isBoolean(2);
    }

    /**
     * @expectedException Stark\Framework\Exception\InvalidParameter
     */
    public function testIsValidatingInteger()
    {
        $this->validation->isInteger('asd');
    }

    /**
     * @expectedException Stark\Framework\Exception\InvalidParameter
     */
    public function testIsValidatingFloat()
    {
        $this->validation->isFloat('asd');
    }

    /**
     * @expectedException Stark\Framework\Exception\InvalidParameter
     */
    public function testIsValidatingNumber()
    {
        $this->validation->isNumber('asd');
    }

    /**
     * @expectedException Stark\Framework\Exception\InvalidParameter
     */
    public function testIsValidatingEmail()
    {
        $this->validation->isEmail('asd@test');
    }

    /**
     * @expectedException Stark\Framework\Exception\InvalidParameter
     */
    public function testIsValidatingUrl()
    {
        $this->validation->isUrl('www.com');
    }

    /**
     * @expectedException Stark\Framework\Exception\InvalidParameter
     */
    public function testIsValidatingAlphanumeric()
    {
        $this->validation->isAlphanumeric('Oi!');
    }

    /**
     * @expectedException Stark\Framework\Exception\InvalidParameter
     */
    public function testIsValidatingAlpha()
    {
        $this->validation->isAlpha('123123');
    }

    /**
     * @expectedException Stark\Framework\Exception\InvalidParameter
     */
    public function testIsValidatingString()
    {
        $this->validation->isString('#$%^&*()');
    }

    /**
     * @expectedException Stark\Framework\Exception\InvalidParameter
     */
    public function testIsValidatingNotBlank()
    {
        $this->validation->isNotBlank('');
    }

    public function testIsSanitizingInteger()
    {
        $result = $this->validation->sanitizeInteger('Oi123');
        $this->assertEquals('123', $result);
    }

    public function testIsSanitizingFloat()
    {
        $result = $this->validation->sanitizeFloat('Oi 1.23');
        $this->assertEquals('1.23', $result);
    }

    public function testIsSanitizingEmail()
    {
        $result = $this->validation->sanitizeEmail("\t\t\ncontato@carlagouve\t\nia.com");
        $this->assertEquals('contato@carlagouveia.com', $result);
    }

    public function testIsSanitizingUrl()
    {
        $result = $this->validation->sanitizeUrl("\t\t\nwww.carlagouve\t\nia.com");
        $this->assertEquals('www.carlagouveia.com', $result);
    }

    public function testIsSanitizingString()
    {
        $result = $this->validation->sanitizeString("\t\nCafé bom!");
        $this->assertEquals('&#9;&#10;Caf&#195;&#169; bom!', $result);
    }
}