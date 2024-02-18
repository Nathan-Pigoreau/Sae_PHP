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

// Session
session_start();
$userRole = isset($_SESSION['user']) ? $_SESSION['user']->getRoleU() : null;

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
    '/favoris' => 'favoris.php',
    '/admin/albums' => 'albums_admin.php',
    '/admin/artistes' => 'artistes_admin.php',
    '/admin/musiques' => 'musiques_admin.php',
    '/admin/albums/modifier' => 'modifier_album.php',
    '/admin/artistes/modifier' => 'modifier_artiste.php',

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
        if ($userRole === 'Admin'){
            include __DIR__ . '/Templates/' . $routes[$uri];
            $template->setLayout('base_admin');
            $template->setContent('$routes[$uri]');
            echo $template->compile();
            break;
        } else {
            include __DIR__ . '/Templates/' . $routes[$uri];
            $template->setLayout('base2');
            $template->setContent('$routes[$uri]');
            echo $template->compile();
            break;
        }
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
    case '/admin/albums':
        if ($userRole === 'Admin') {
            include __DIR__ . '/Templates/albums_admin.php';
            $template->setLayout('base_admin');
            $template->setContent('albums_admin.php');
            echo $template->compile();
        } else {
            // Redirection ou traitement pour l'accès non autorisé
        }
        break;
    case '/admin/albums/modifier':
        if ($userRole === 'Admin') {
            include __DIR__ . '/Templates/modifier_album.php';
            $template->setLayout('base_admin');
            $template->setContent('modifier_album.php');
            echo $template->compile();
        } else {
            // Redirection ou traitement pour l'accès non autorisé
        }
        break;
    case '/admin/artistes':
        if ($userRole === 'Admin') {
            include __DIR__ . '/Templates/artistes_admin.php';
            $template->setLayout('base_admin');
            $template->setContent('artistes_admin.php');
            echo $template->compile();
        } else {
            // Redirection ou traitement pour l'accès non autorisé
        }
        break;
    case '/admin/artistes/modifier':
        if ($userRole === 'Admin') {
            include __DIR__ . '/Templates/modifier_artiste.php';
            $template->setLayout('base_admin');
            $template->setContent('modifier_artiste.php');
            echo $template->compile();
        } else {
            // Redirection ou traitement pour l'accès non autorisé
        }
        break;
    case '/admin/musiques':
        if ($userRole === 'Admin') {
            include __DIR__ . '/Templates/musiques_admin.php';
            $template->setLayout('base_admin');
            $template->setContent('musiques_admin.php');
            echo $template->compile();
        } else {
            // Redirection ou traitement pour l'accès non autorisé
        }
        break;
    default:
        if ($userRole === 'user'){
            include __DIR__ . '/Templates/main.php';
            $template->setLayout('base2');
            $template->setContent('main.php');
            echo $template->compile();
            break;
        } else {
            include __DIR__ . '/Templates/main.php';
            $template->setLayout('base_admin');
            $template->setContent('main.php');
            echo $template->compile();
            break;
        }
}
?>