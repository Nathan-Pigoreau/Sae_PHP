<?php
// Chemin pour accéder à la base de données
require_once 'Configuration/config.php';

// SPL autoloader
require_once '/Classes/autoloader.php'; 

header("Location: ./Templates/home.php");
exit();
?>