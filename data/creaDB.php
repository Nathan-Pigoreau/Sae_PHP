<?php

try {
    $sql = file_get_contents("data/SQL/creaDB.sql");
    $db = new \PDO("sqlite:db.sqlite3");
    $db->exec($sql);
    $db = null;
    
    echo "Script SQL exécuté avec succès !";
} catch (\Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>