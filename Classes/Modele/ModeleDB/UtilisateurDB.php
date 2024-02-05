<?php

declare(strict_types=1);

namespace Modele\ModeleDB;

use PDO;
use Modele\Utilisateur;
use Modele\DataBase;

require_once(__DIR__ . '/../DataBase.php');
require_once(__DIR__ . '/../../autoloader.php');

final class UtilisateurDB
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DataBase::getInstance();
    }

    
    public function connexionUser(String $email, String $password)
    {
        $query = "SELECT * FROM utilisateur WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == null)
            return false;

        return password_verify($password, $user['mdp']);
    }

    public function inscriptionUser(String $pseudo, String $email, String $password): void
    {
        $query = "INSERT INTO utilisateur (pseudo, email, password) VALUES (:pseudo, :email, :password)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":password", password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
        $stmt->bindParam(":roleU", "user", PDO::PARAM_STR);
        $stmt->binParam(":descriptionU", "Nouvel utilisateur", PDO::PARAM_STR);
        $stmt->execute();
    }

    public function initUser(int $id): void
    {
        $_SESSION['id'] = $id;
    }

}


