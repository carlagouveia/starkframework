<?php

namespace Stark\Framework\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerAware;

class Controller extends ContainerAware
{
    protected function renderView($view, array $parameters = array())
    {
        return $this->container->get('view')->render($view, $parameters);
    }

    protected function render($view, array $parameters = array())
    {
        $class = join('', array_slice(explode('\\', get_class($this)), -1));
        $view = sprintf('%s/%s.html', $class, $view);

        $output = $this->renderView($view, $parameters);
        return new Response($output);
    }

    protected function getRequest()
    {
        return $this->container->get('request');
    }

    protected function getPost()
    {
        return $this->container->get('request')->request;
    }

    protected function getQuery()
    {
        return $this->container->get('request')->query;
    }

    protected function has($id)
    {
        return $this->container->has($id);
    }

    protected function get($id)
    {
        return $this->container->get($id);
    }

    protected function getConfig($id)
    {
        return $this->container->getParameter($id);
    }
}