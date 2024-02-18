<?php

declare(strict_types=1);

use Modele\ModeleDB\ArtisteDB;

require_once '../../Classes/autoloader.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idArtiste = isset($_POST["id"]) ? (int)$_POST["id"] : 0;

    if ($idArtiste > 0) {
        $artisteDB = new ArtisteDB();
        
        if ($artisteDB->artisteExistsId($idArtiste)) {
            $artisteDB->deleteArtiste($idArtiste);
            echo json_encode(['success' => true]);
            exit();
        } else {
            echo json_encode(['error' => 'Artiste non trouvé']);
            exit();
        }
    } else {
        echo json_encode(['error' => 'ID d\'artiste non valide']);
        exit();
    }
} else {
    echo json_encode(['error' => 'Requête non valide']);
    exit();
}