<?php
namespace Controller;

require_once '../autoloader.php';

use Modele\ModeleDB\UtilisateurDB;

session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$id_utilisateur_connecte = $user ? $user->getIdUser() : null;

if ($id_utilisateur_connecte && isset($_POST['idMusique'])) {
    $__USER__ = new UtilisateurDB();
    if($__USER__->isFavoris($id_utilisateur_connecte, intval($_POST['idMusique']) == false)){
        $idMusique = intval($_POST['idMusique']);
        $user->addFavoris($idMusique);
        echo "like";
    }else{
        $idMusique = intval($_POST['idMusique']);
        $user->removeFavoris($id_utilisateur_connecte, $idMusique);
        echo "dislike";
    }
} else {
    http_response_code(400);
    echo "Error: Invalid request.";
}
?>