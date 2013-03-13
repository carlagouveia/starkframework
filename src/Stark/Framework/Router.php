<?php

namespace Stark\Framework;

use Stark\Framework\Exception\NotFoundHttpException;
use Stark\Framework\Exception\BadRequestHttpException;

class Router
{
    protected $path;
    protected $container;

    public function __construct($path, $container)
    {
        $this->path = $path;
        $this->container = $container;
    }

    public function dispatch()
    {
        $result = preg_match_all('/([a-zA-Z]+)\/([a-zA-Z]+)/', $this->path, $params, PREG_SET_ORDER);

        if ($result !== 1) {
            throw new BadRequestHttpException('Missing route');
        }

        $controllerClass = $this->getControllerClass($params[0][1]);
        $action = $this->getControllerAction($controllerClass, $params[0][2]);
        $controller = new $controllerClass;
        $controller->setContainer($this->container);
        return $controller->$action();
    }

    protected function getControllerClass($controller)
    {
        $controller = str_replace(' ', '', ucwords(str_replace('_', ' ', $controller)));
        $controller = '\\Stark\\Application\\Controller\\' . $controller . 'Controller';

        if (!class_exists($controller)) {
            throw new NotFoundHttpException('Invalid route');
        }

        return $controller;
    }

    protected function getControllerAction($controller, $action)
    {
        $action = str_replace(' ', '', ucwords(str_replace('_', ' ', $action)));
        $action = lcfirst($action . 'Action');

        if (!method_exists($controller, $action)) {
            throw new NotFoundHttpException('Invalid route');
        }

        return $action;
    }
}