<?php
namespace Controller;

use Modele\ModeleDB\UtilisateurDB;
use Modele\Utilisateur;
use View\Template;

require_once '../../Classes/autoloader.php';

$__USER__ = new UtilisateurDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        if ($__USER__->connexionUser($_POST['email'], $_POST['password'])) {
            header('Location: /');
        } else {
            header('Location: login?error=1');
        }
    }
}