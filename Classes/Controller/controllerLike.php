<?php
namespace Controller;

require_once '../autoloader.php';

use Modele\ModeleDB\UtilisateurDB;

session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$id_utilisateur_connecte = $user ? $user->getIdUser() : null;

if ($id_utilisateur_connecte && isset($_POST['idMusique'])) {
    $__USER__ = new UtilisateurDB();
    $idMusique = intval($_POST['idMusique']);
    if($__USER__->isFavoris($id_utilisateur_connecte, $idMusique) === false){
        $user->addFavoris($__USER__->getMusique($idMusique));
        $__USER__->addFavoris($id_utilisateur_connecte, $idMusique);
        echo "like";
    }else{
        $user->removeFavoris($idMusique);
        $__USER__->removeFavoris($id_utilisateur_connecte, $idMusique);
        echo "dislike";
    }
} else {
    echo "Error";
}
?>