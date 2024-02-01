<?php
use Provider\DataLoaderSqlite;
use Repository\QuestionRepository;
use Provider\DataLoaderJson;
use View\Template;


require_once 'Configuration/config.php';

// SPL autoloader
require 'Classes/autoloader.php'; 
Autoloader::register(); 

$action = $_REQUEST['action'] ?? false;

ob_start();
switch ($action) {
    case 'submit':
        include 'Action/submit.php';
        break;
        
    default:
        include 'Action/form.php';
        break;
}
$content = ob_get_clean();

// Template
$template = new Template('templates');
$template->setLayout('accueil');
$template->setContent($content);

echo $template->compile();

