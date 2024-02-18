<?php

declare(strict_types=1);

namespace Controller;

use Modele\ModeleDB\ArtisteDB;

require_once '../../Classes/autoloader.php';

$artisteDB = new ArtisteDB();

session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$id_utilisateur_connecte = $user ? $user->getIdUser() : null;

if ($id_utilisateur_connecte) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idArtiste = $_POST["idArtiste"];
        $nomA = $_POST["nomA"];
        $prenomA = $_POST["prenomA"];
        $descriptionA = $_POST["descriptionA"];

        $artiste = $artisteDB->getArtiste((int)$idArtiste);

        $artiste->setNomA($nomA);
        $artiste->setPrenomA($prenomA);
        $artiste->setDescriptionA($descriptionA);

        $artisteDB->updateArtiste($artiste);

        // Rediriger vers la page de détails de l'artiste
        header("Location: /artiste-details?id=" . $idArtiste);
        exit();
    } else {
        // Rediriger vers la page d'accueil si la méthode de la requête n'est pas POST
        header("Location: /");
        exit();
    }
} else {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: /login");
    exit();
}
?>