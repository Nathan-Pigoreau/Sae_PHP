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
    '/playlists' => 'playlists.php',
    '/playlist-details' => 'details/playlist-details.php',
    '/album-details' => 'details/album-details.php',
    '/artiste-details' => 'details/artiste-details.php',
    '/musique-details' => 'details/musique-details.php',
    '/musiques' => 'musiques.php',
    '/albums' => 'albums.php',
    '/favoris' => 'favoris.php'

];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parts = explode('/', $uri);

switch(isset($routes[$uri]))
{
    case '/logout':
        include __DIR__ . '/Templates/' . $routes[$uri];
        $template->setLayout('base2');
        $template->setContent('$routes[$uri]');
        echo $template->compile();
        break;
    case '/login':
        include __DIR__ . '/Templates/' . $routes[$uri];
        $template->setLayout('base2');
        $template->setContent('$routes[$uri]');
        echo $template->compile();
        break;
    case '/register':
        include __DIR__ . '/Templates/' . $routes[$uri];
        $template->setLayout('base2');
        $template->setContent('$routes[$uri]');
        echo $template->compile();
        break;
    case '/':
        include __DIR__ . '/Templates/' . $routes[$uri];
        $template->setLayout('base2');
        $template->setContent('$routes[$uri]');
        echo $template->compile();
        break;
    case '/playlists':
        include __DIR__ . '/Templates/' . $routes[$uri];
        $template->setLayout('base2');
        $template->setContent('$routes[$uri]');
        echo $template->compile();
        break;
    case '/playlist-details':
        include __DIR__ . '/Templates/' . $routes[$uri];
        $template->setLayout('base2');
        $template->setContent('$routes[$uri]');
        echo $template->compile();
        break;
    case '/album-details':
        include __DIR__ . '/Templates/' . $routes[$uri];
        $template->setLayout('base2');
        $template->setContent('$routes[$uri]');
        echo $template->compile();
        break;
    case '/artiste-details':
        include __DIR__ . '/Templates/' . $routes[$uri];
        $template->setLayout('base2');
        $template->setContent('$routes[$uri]');
        echo $template->compile();
        break;
    case '/musique-details':
        include __DIR__ . '/Templates/' . $routes[$uri];
        $template->setLayout('base2');
        $template->setContent('$routes[$uri]');
        echo $template->compile();
        break;
    case '/albums':
        include __DIR__ . '/Templates/' . $routes[$uri];
        $template->setLayout('base2');
        $template->setContent('$routes[$uri]');
        echo $template->compile();
        break;
    case '/musiques':
        include __DIR__ . '/Templates/' . $routes[$uri];
        $template->setLayout('base2');
        $template->setContent('$routes[$uri]');
        echo $template->compile();
        break;
    case '/favoris':
        include __DIR__ . '/Templates/' . $routes[$uri];
        $template->setLayout('base2');
        $template->setContent('routes[$uri]');
        echo $template->compile();
        break;
    default:
        include __DIR__ . '/Templates/main.php';
        $template->setLayout('base2');
        $template->setContent('main.php');
        echo $template->compile();
        break;
}
