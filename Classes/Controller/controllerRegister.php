<?php
namespace Controller;

use Modele\ModeleDB\UtilisateurDB;
use Modele\Utilisateur;

require_once '../autoloader.php';
require_once '../Modele/ModeleDB/UtilisateurDB.php';

$__USER__ = new UtilisateurDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['email'])){ 
        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        $user = $__USER__->getUserByEmail($email);

        if ($user) {
            //Identifiants déjà utilisés, rediriger avec un message d'erreur
            header("Location: ../../Templates/register.php?error=1");
                exit(); 
        } else {
            // Ajout de l'utilisateur
            $user = $__USER__->addUser($pseudo, $email, $password);
            header("Location: ../../Templates/home.php");
            exit();
        }}}