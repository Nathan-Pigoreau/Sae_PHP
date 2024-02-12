<?php

use Provider\DataLoaderSqlite;
use Repository\QuestionRepository;
use Provider\DataLoaderJson;
use View\Template;

require_once 'Configuration/config.php';

// SPL autoloader
require 'Classes/autoloader.php'; 
// Template

$template = new Template('Templates');

$routes = [
    '/logout' => 'logout.php',
    '/login' => 'login.php',
    '/register' => 'register.php',
    '/' => 'main.php'
];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if(isset($routes[$uri]))
{
    include __DIR__ . '/Templates/' . $routes[$uri];
    $template->setLayout('base2');
    $template->setContent('$routes[$uri]');
    echo $template->compile();
} else{
    $template->setLayout('base');
    $template->setContent('main.php');
    echo $template->compile();
}
