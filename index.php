<?php

require 'vendor/autoload.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\Helper\SlotsHelper;
use Symfony\Component\Templating\Helper\AssetsHelper;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Stark\Framework\Config;
use Stark\Framework\Router;
use Stark\Framework\ErrorHandler;
use Stark\Framework\Exception\HttpExceptionInterface;

// Creating the DIC
$container = new ContainerBuilder();

// Importing configuration data to the container
$config = new Config(__DIR__ . '/config.ini');
$config->import($container);

// Define error handling behavior
ini_set('display_errors', 0);
if ($container->getParameter('app.debug')) {
    ErrorHandler::register(-1);
} else {
    ErrorHandler::register(E_ALL ^ E_NOTICE);
}

// Creating the View object
$loader = new FilesystemLoader(__DIR__ . '/views/%name%');
$view = new PhpEngine(new TemplateNameParser(), $loader);
$view->set(new SlotsHelper());
$view->set(new AssetsHelper(__DIR__ . '/assets/', $container->getParameter('app.url') . '/assets/'));
$container->set('view', $view);

// Creating the Database object
$connection = new Connection(
    $container->getParameter('database.driver'),
    $container->getParameter('database.host'),
    $container->getParameter('database.name'),
    $container->getParameter('database.user'),
    $container->getParameter('database.password')
);
$container->set('db', new Manager($connection));

// Log manager
$log = new Logger($container->getParameter('app.name'));
$log->pushHandler(new StreamHandler(__DIR__ . '/error.log', Logger::WARNING));
$container->set('log', $log);

// Creating the Request object
$request = Request::createFromGlobals();
$container->set('request', $request);

// Parse the request path and dispatch available routes
try {
    $router = new Router($request->getPathInfo(), $container);
    $response = $router->dispatch();
} catch (HttpExceptionInterface $e) {
    $message = sprintf('Error %s at %s in line %s: %s', $e->getCode(), $e->getFile(), $e->getLine(), $e->getMessage());
    $log->addError($message);
    $response = new Response($e->getMessage(), $e->getStatusCode());
}

$response->send();