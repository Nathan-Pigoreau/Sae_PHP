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
    '/' => 'main.php',
    '/playlists' => 'playlists.php'
];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parts = explode('/', $uri);

if ($parts[1] === 'playlist' && isset($parts[2]) && is_numeric($parts[2])) {
    $id = intval($parts[2]);
    $template->setLayout('base2');
    $template->setContent('playlist.php');
    echo $template->compile();
} else {
    $id = null;
}

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
