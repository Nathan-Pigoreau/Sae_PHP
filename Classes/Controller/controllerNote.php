<?php

namespace Controller;

require_once '../autoloader.php';

use Modele\ModeleDB\UtilisateurDB;

session_start();

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$id_utilisateur_connecte = $user ? $user->getIdUser() : null;

if ($id_utilisateur_connecte && isset($_POST['idAlbum'])){
    $__USER__ = new UtilisateurDB();
    $idAlbum = intval($_POST['idAlbum']);
    $note = intval($_POST['note']);
    if($__USER__->isNoteExist($id_utilisateur_connecte, $idAlbum) === false){
        $__USER__->addNoteAlbum($id_utilisateur_connecte, $idAlbum, $note);
        header("Location: /album-details?id=" . $idAlbum);
    }else{
        $__USER__->updateAlbumNote($id_utilisateur_connecte, $idAlbum, $note);
        header("Location: /album-details?id=" . $idAlbum);
    }
} else {
    header("Location: /login");
}