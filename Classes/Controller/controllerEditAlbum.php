<?php

declare(strict_types=1);

namespace Controller;

use Modele\ModeleDB\AlbumDB;
use Modele\ModeleDB\GenreDB;
use Modele\Album;

require_once '../../Classes/autoloader.php';

$__ALBUM__ = new AlbumDB();
$genreDB = new GenreDB();

session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$id_utilisateur_connecte = $user ? $user->getIdUser() : null;

if ($id_utilisateur_connecte) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idAlbum = $_POST["idAlbum"];
        $nomAlbum = $_POST["nomAlbum"];
        $releaseYear = $_POST["releaseYear"];
        $idArtiste = $_POST["idArtiste"];
        $genres = isset($_POST['idGenre']) ? $_POST['idGenre'] : [];

        $album = $__ALBUM__->getAlbum($idAlbum);
        $ancienNomImage = $album->getImage();

        if (isset($_FILES["newAlbumImage"]) && $_FILES["newAlbumImage"]["size"] > 0) {
            if (file_exists(__DIR__ . '/../../Static/images/' . $ancienNomImage)) {
                unlink(__DIR__ . '/../../Static/images/' . $ancienNomImage);
            }

            $nouveauNomImage = $_FILES["newAlbumImage"]["name"];
            move_uploaded_file($_FILES['newAlbumImage']['tmp_name'], __DIR__ . '/../../Static/images/' . $nouveauNomImage);
        } else {
            $nouveauNomImage = $ancienNomImage;
        }

        $album = $__ALBUM__->getAlbum($idAlbum);
        $album->setNomAlbum($nomAlbum);
        $album->setReleaseYear((int)$releaseYear);
        $album->setIdArtiste((int)$idArtiste);
        $album->setImageAlbum($nouveauNomImage);
        if (count($genres) > 0) {
            $album->resetGenre();
            foreach ($genres as $genreId) {
                $genre = $genreDB->getGenre(intval($genreId));
                $album->addGenre($genre);
            }
        }
        $__ALBUM__->updateAlbum($album);

        header("Location: /album/detail/" . $idAlbum);
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