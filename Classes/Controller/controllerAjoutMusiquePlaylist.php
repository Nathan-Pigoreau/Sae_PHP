<?php

declare(strict_types=1);

namespace Controller;

require_once '../autoloader.php';

use Modele\ModeleDB\PlaylistDB;

$__PLAYLIST__ = new PlaylistDB();

session_start();

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$id_utilisateur_connecte = $user ? $user->getIdUser() : null;

if($id_utilisateur_connecte){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idPlaylist = (int)$_POST["idPlaylist"];
        $idMusique = (int)$_POST["idMusique"];
        $playlist = $__PLAYLIST__->getPlaylist($idPlaylist);
        if($playlist->getIdUser() == $id_utilisateur_connecte){
            $__PLAYLIST__->addPlaylistMusique($idPlaylist, $idMusique);
            $musique = $__PLAYLIST__->getMusique($idMusique);
            $playlist->addMusique($musique);
            header("Location: /playlist-details?id=" . $idPlaylist);
            exit();
        }
        else{
            header("Location: /");
        }
}}
