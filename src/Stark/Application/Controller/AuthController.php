<?php

namespace Stark\Application\Controller;

use Stark\Framework\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function exampleAction()
    {
        // Working with the database
        $result = $this->get('db')->query('SELECT * FROM table');
        $this->get('db')->create('table', array('title' => 'My test', 'date' => 123456));

        // Logging
        $this->get('log')->addError('An error happened!');

        // Acessing configuration
        $this->getConfig('app.name');

        // Handling user input
        $this->getPost()->get('test'); // Getting variable 'test' from POST
        $this->getQuery()->get('anotherTest'); // Getting variable 'anotherTest' from GET

        // Rendering views
        return $this->render('name', array('teste' => 'Oi mundo'));
    }

    public function nameAction()
    {
        return $this->render('name', array('teste' => 'Oi mundo'));
    }
}