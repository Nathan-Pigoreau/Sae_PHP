<?php

declare(strict_types=1);

namespace Controller;

use Modele\ModeleDB\AlbumDB;

require_once '../../Classes/autoloader.php';

// Initialisation de la connexion à la base de données
$__ALBUM__ = new AlbumDB();

// Assurez-vous que la requête est de type POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer l'ID de l'album à supprimer à partir des données POST
    $idAlbum = isset($_POST['id']) ? intval($_POST['id']) : 0;

    // Vérifiez si l'ID de l'album est valide
    if ($idAlbum > 0) {
        // Supprimez l'album de la base de données
        $__ALBUM__->deleteAlbum($idAlbum);

        // Envoyez une réponse JSON indiquant que la suppression a réussi
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit();
    }
}

// Si la requête n'est pas de type POST ou si l'ID de l'album est invalide, renvoyez une réponse JSON d'échec
header('Content-Type: application/json');
echo json_encode(['success' => false, 'error' => 'Invalid request']);
exit();