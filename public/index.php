<?php
session_start();

/**
 * Composer
 */
require '../vendor/autoload.php';

/**
 * Error and Exception handling
 */
// set_error_handler('Core\Error::errorHandler');
// set_exception_handler('Core\Error::exceptionHandler');

/**
 * Routing
 */
$router = new Core\Router();

$router->add('', ['controller' => 'pages', 'action' => 'show-page', 'page' => 'home']);
$router->add('contact', ['controller' => 'pages', 'action' => 'show-page', 'page' => 'contact']);

$router->add('projects', ['controller' => 'projects', 'action' => "all-projects", "page" => "projects"]);
$router->add('projects/update', ['controller' => 'projects', 'action' => "update"]);
$router->add('projects/{id}', ['controller' => 'projects', 'action' => "show-project", "page" => "projects"]);

$router->dispatch($_SERVER['QUERY_STRING']);
