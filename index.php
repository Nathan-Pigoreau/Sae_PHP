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

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parts = explode('/', $uri);

// Vérifier si l'utilisateur a le rôle "Admin"
session_start();
$userRole = isset($_SESSION['user']) ? $_SESSION['user']->getRoleU() : null;

// Vérifier si l'URL correspond à /playlist/x
if ($parts[1] === 'playlist' && isset($parts[2]) && is_numeric($parts[2])) {
    $id = intval($parts[2]);
    $template->setLayout('base2');
    $template->setContent('playlist.php');
    echo $template->compile();
} else {
    $id = null;

    // Vérifier si l'URL correspond à une des routes prédéfinies
    $routes = [
        '/logout' => 'logout.php',
        '/login' => 'login.php',
        '/register' => 'register.php',
        '/' => 'main.php',
        '/playlists' => 'playlists.php',
        '/admin/albums' => 'albums_admin.php',
        '/admin/artistes' => 'artistes_admin.php',
        '/admin/musiques' => 'musiques_admin.php',
        '/admin/albums/modifier' => 'modifier_album.php',
    ];

    // Si l'URL est la route 'admin/albums' et l'utilisateur a le rôle "Admin"
    if ($uri === '/admin/albums' && $userRole === 'Admin') {
        include __DIR__ . '/Templates/albums_admin.php';
        $template->setLayout('base_admin');
        $template->setContent('albums_admin.php');
        echo $template->compile();
    }
    elseif ($uri === '/admin/albums/modifier' && $userRole === 'Admin') {
        include __DIR__ . '/Templates/modifier_album.php';
        $template->setLayout('base_admin');
        $template->setContent('modifier_album.php');
        echo $template->compile();
    }
    elseif ($uri === '/admin/artistes' && $userRole === 'Admin') {
        include __DIR__ . '/Templates/artistes_admin.php';
        $template->setLayout('base_admin');
        $template->setContent('artistes_admin.php');
        echo $template->compile();
    }
    elseif ($uri === '/admin/artistes/modifier' && $userRole === 'Admin') {
        include __DIR__ . '/Templates/modifier_artiste.php';
        $template->setLayout('base_admin');
        $template->setContent('modifier_artiste.php');
        echo $template->compile();
    }
    elseif ($uri === '/admin/musiques' && $userRole === 'Admin') {
        include __DIR__ . '/Templates/musiques_admin.php';
        $template->setLayout('base_admin');
        $template->setContent('musiques_admin.php');
        echo $template->compile();
    }
    // Si l'URL est une route standard, inclure le fichier correspondant et utiliser le layout standard
    elseif (isset($routes[$uri])) {
        include __DIR__ . '/Templates/' . $routes[$uri];
        $template->setLayout('base2');
        $template->setContent($routes[$uri]);
        echo $template->compile();
    } 
    // Si pas de page et utilisateur est admin
    elseif ($userRole === 'Admin') {
        $template->setLayout('base_admin');
        $template->setContent('admin_page.php');
        echo $template->compile();
    }
    // Aucune correspondance avec une route prédéfinie, afficher la page par défaut
    else {
        $template->setLayout('base');
        $template->setContent('main.php');
        echo $template->compile();
    }
}
?>