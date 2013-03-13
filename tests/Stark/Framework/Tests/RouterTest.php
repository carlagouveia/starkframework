<?php

namespace Stark\Framework\Tests;

use Stark\Framework\Router;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RouterTest extends \PHPUnit_Framework_TestCase
{
    protected $container;

    public function setUp()
    {
        $this->container = new ContainerBuilder();
    }

    /**
     * @expectedException \Stark\Framework\Exception\BadRequestHttpException
     */
    public function testIsDetectingBadRoute()
    {
        $router = new Router('/action', $this->container);
        $router->dispatch();
    }
}