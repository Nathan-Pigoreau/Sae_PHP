<?php
namespace Controller;

use Modele\ModeleDB\UtilisateurDB;
use Modele\Utilisateur;

require_once '../autoloader.php';
require_once '../Modele/ModeleDB/UtilisateurDB.php';

$__USER__ = new UtilisateurDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        if ($__USER__->connexionUser($_POST['email'], $_POST['password'])) {
            header('Location: ../../Templates/home.php');
        } else {
            header('Location: ../../Templates/login.php');
        }
    }
}