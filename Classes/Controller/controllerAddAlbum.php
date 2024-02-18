<?php

declare(strict_types=1);

namespace Controller;

use Modele\ModeleDB\AlbumDB;

require_once '../../Classes/autoloader.php';

$__ALBUM__ = new AlbumDB();

session_start();
$user = $_SESSION['user'] ?? null;
$id_utilisateur_connecte = $user ? $user->getIdUser() : null;

if ($id_utilisateur_connecte) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newAlbumName = $_POST["newAlbumName"];
        $newAlbumReleaseYear = $_POST["newAlbumReleaseYear"];
        $imagePath = $_FILES["newAlbumImage"]["name"];
        $artiste = $_POST["newAlbumArtist"];
        $idArtiste = $__ALBUM__->getIdArtiste($artiste);
        $imageAlbum = '../../Static/images/' . $imagePath;
        move_uploaded_file($_FILES['newAlbumImage']['tmp_name'], $imageAlbum);
        $imageFileName = basename($imageAlbum);

        if (!file_exists($imageAlbum)) {
            echo '<script>alert("Un problème est survenu lors de l\'upload de l\'image path: ' . $imageAlbum . '");</script>';
            echo '<script>window.location.href = "/admin/albums";</script>';
            exit();
        }

        if (!is_numeric($newAlbumReleaseYear)) {
            echo '<script>alert("L\'année de sortie doit être un nombre entier");</script>';
            echo '<script>window.location.href = "/admin/albums";</script>';
            exit();
        }

        if ($idArtiste === null) {
            echo '<script>alert("L\'artiste n\'existe pas");</script>';
            echo '<script>window.location.href = "/admin/albums";</script>';
            exit();
        }

        if ($__ALBUM__->albumExists($newAlbumName)) {
            echo '<script>alert("L\'album ' . $newAlbumName . ' existe déjà");</script>';
            echo '<script>window.location.href = "/admin/albums";</script>';
            exit();
        }

        $__ALBUM__->addAlbumWithoutId((int)$idArtiste, $newAlbumName, (int)$newAlbumReleaseYear, $imageFileName);
        header("Location: /admin/albums");
        exit();
    } else {
        header("Location: /");
        exit();
    }
} else {
    header("Location: /login");
    exit();
}
?>