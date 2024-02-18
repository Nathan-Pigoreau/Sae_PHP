<?php

declare(strict_types=1);

namespace Controller;

require_once '../autoloader.php';

use Modele\ModeleDB\PlaylistDB;

session_start();

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

if ($user) {
    $id_utilisateur_connecte = $user->getIdUser();
    $idMusique = $_POST['idMusique'];
    $idPlaylist = $_POST['idPlaylist'];
    $playlistDB = new PlaylistDB();
    $playlistDB->addMusique($idMusique, $idPlaylist);
    echo "musique ajoutée";
} else {
    echo "Error";
}