<?php

declare(strict_types=1);

namespace Controller;

use Modele\ModeleDB\MusiqueDB;
use Modele\Musique;

require_once '../../Classes/autoloader.php';

$__MUSIQUE__ = new MusiqueDB();

session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$id_utilisateur_connecte = $user ? $user->getIdUser() : null;

if ($id_utilisateur_connecte) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Modifier une musique existante
        $idMusique = $_POST["idMusique"];
        $editedMusiqueName = $_POST["editedMusiqueName"];
        $editedMusiqueReleaseYear = $_POST["editedMusiqueReleaseYear"];
        $editedMusiqueArtist = $_POST["editedMusiqueArtist"];

        // Effectuez les vérifications et le traitement nécessaire pour la modification de musique
        // ... (ex: validation des données, mise à jour de l'image, etc.)

        // Obtenez l'objet Musique existant depuis la base de données
        $editedMusique = $__MUSIQUE__->getMusique($idMusique);

        // Mettez à jour les propriétés de la musique
        $editedMusique->setNomMusique($editedMusiqueName);
        $editedMusique->setRealeaseYear($editedMusiqueReleaseYear);
        $editedMusique->setIdArtiste($editedMusiqueArtist);

        // Effectuez d'autres mises à jour selon vos besoins

        // Enregistrez les modifications dans la base de données
        $editedMusique->updateMusique();

        // Redirigez ou renvoyez la réponse appropriée
        header("Location: /musique/detail/" . $editedMusique->getIdMusique());
        exit();
    }
} else {
    header("Location: /login");
    exit();
}