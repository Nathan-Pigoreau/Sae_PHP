<?php

declare(strict_types=1);

namespace Controller;

use Modele\ModeleDB\MusiqueDB;
use Modele\Musique;
use Modele\ModeleDB\ArtisteDB;

require_once '../../Classes/autoloader.php';

$__MUSIQUE__ = new MusiqueDB();
$__ARTISTE__ = new ArtisteDB();

session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$id_utilisateur_connecte = $user ? $user->getIdUser() : null;

if ($id_utilisateur_connecte) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ajouter une nouvelle musique
        $newMusiqueName = $_POST["newMusiqueName"];
        $newMusiqueReleaseYear = $_POST["newMusiqueReleaseYear"];
        $releaseYear = (int)$newMusiqueReleaseYear;
        $newMusiqueArtist = $_POST["newMusiqueArtist"];

        $idArtiste = $__ARTISTE__->getArtisteIdByName($newMusiqueArtist);

        // Créez un objet Musique avec les données fournies
        $newMusique = new Musique(
            0,  // L'ID sera généré automatiquement dans la base de données
            $idArtiste,
            $newMusiqueName,
            $releaseYear,
            '',  // Remplacez cette chaîne vide par le chemin de l'image sauvegardée
            0    // Vous pouvez définir le nombre de vues initial ici
        );

        $__MUSIQUE__->addMusique($idArtiste, $newMusiqueName, $releaseYear, '', $idAlbum);

        // Redirigez ou renvoyez la réponse appropriée
        header("Location: /musique/detail/" . $newMusique->getIdMusique());
        exit();
    }
} else {
    header("Location: /login");
    exit();
}