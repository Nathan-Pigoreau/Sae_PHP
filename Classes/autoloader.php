<?php

spl_autoload_register(function ($className) {
    // Convertit le nom de classe en chemin de fichier
    $filePath = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';

    // Vérifie si le fichier existe et le charge s'il existe
    if (file_exists($filePath)) {
        require_once $filePath;
    }
});
?>