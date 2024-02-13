<?php
declare(strict_types=1);

namespace Controller;

use Modele\ModeleDB\PlaylistDB;

require_once '../../Classes/autoloader.php';

$__PLAYLIST__ = new PlaylistDB();

session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$id_utilisateur_connecte = $user ? $user->getIdUser() : null;

if ($id_utilisateur_connecte) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom_playlist = $_POST["nom_playlist"];

        $__PLAYLIST__->ajouterPlaylist($nom_playlist, $id_utilisateur_connecte);
        $playlistId = $__PLAYLIST__->getPlaylistId($nom_playlist);

        if ($playlistId) {
            $__PLAYLIST__->initPlaylist($playlistId);
            header("Location: /playlist/" . $playlistId);
            exit();
        } else {
            header("Location: page_erreur.php");
            exit();
        }
    } else {
        header("Location: " . "/playlist");
        exit();
    }
} else {
    header("Location: " . "/login");
    exit();
}
?>