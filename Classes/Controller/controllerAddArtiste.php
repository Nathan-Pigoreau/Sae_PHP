<?php

declare(strict_types=1);

namespace Controller;

use Modele\ModeleDB\ArtisteDB;

require_once '../../Classes/autoloader.php';

// Initialisation de la connexion à la base de données
$__ARTISTE__ = new ArtisteDB();

// Assurez-vous que la requête est de type POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nomA = isset($_POST['newArtisteName']) ? $_POST['newArtisteName'] : '';
    $prenomA = isset($_POST['newArtisteFirstName']) ? $_POST['newArtisteFirstName'] : '';
    $descriptionA = isset($_POST['newArtisteDescription']) ? $_POST['newArtisteDescription'] : '';

    // Ajoutez l'artiste à la base de données
    $__ARTISTE__->ajouterArtiste($nomA, $prenomA, $descriptionA);

    // Redirigez vers la page d'administration des artistes (ajustez l'URL selon votre structure)
    header("Location: /admin/artistes");
    exit();
}

// Si la requête n'est pas de type POST ou si les données du formulaire sont manquantes, renvoyez une réponse JSON d'échec
header('Content-Type: application/json');
echo json_encode(['success' => false, 'error' => 'Invalid request']);
exit();