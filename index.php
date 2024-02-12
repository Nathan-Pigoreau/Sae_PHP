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
$template->setLayout('main');
// $template->setContent($content);

echo $template->compile();
