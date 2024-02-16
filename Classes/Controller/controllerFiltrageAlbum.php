<?php
declare(strict_types=1);
namespace Controller;
require_once '../autoloader.php';
use Modele\ModeleDB\AlbumDB;

$__ALBUM__ = new AlbumDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedGenre = (int)$_POST["selectedGenre"];
    $selectedYear = (int)($_POST["selectedYear"]);

    if ($selectedGenre == "0" && $selectedYear == null) {
        $albums = $__ALBUM__->getAlbums();
    }
    elseif ($selectedGenre == "0") {
        $albums = $__ALBUM__->filtreAlbumYear($selectedYear);
    }
    elseif ($selectedYear == null) {
        $albums = $__ALBUM__->filtreAlbumGenre($selectedGenre);
    } else {
        $albums = $__ALBUM__->filtreAlbum($selectedGenre, $selectedYear);
    }

    $reponse = [];
    foreach ($albums as $album) {
        array_push($reponse, $album->toArray());
    }


    echo json_encode($reponse);
}
