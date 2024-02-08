<?php

declare(strict_types=1);

namespace Modele\ModeleDB;

use PDO;
use Modele\Utilisateur;
use Modele\DataBase;
use Modele\ModeleDB\PlaylistDB;
use Modele\ModeleDB\MusiqueDB;

require_once(__DIR__ . '/../DataBase.php');
require_once(__DIR__ . '/../Utilisateur.php');
require_once(__DIR__ . '/../../autoloader.php');
require_once(__DIR__ . '/PlaylistDB.php');
require_once(__DIR__ . '/MusiqueDB.php');

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

    public function addUser(String $pseudo, String $email, String $mdp): void
    {
        $hashedPassword = password_hash($mdp, PASSWORD_DEFAULT);
        $role = "user";
        $description = "Nouvel utilisateur";

        $query = "INSERT INTO utilisateur (pseudo, email, mdp, roleU, descriptionU) VALUES (:pseudo, :email, :mdp, :roleU, :descriptionU)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":mdp", $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(":roleU", $role, PDO::PARAM_STR);
        $stmt->bindParam(":descriptionU", $description, PDO::PARAM_STR);
        $stmt->execute();

        // Récupérer l'ID de la dernière insertion en utilisant PDO
        $lastInsertId = intval($this->db->lastInsertId());

        $this->initNewUser($lastInsertId, $pseudo, $hashedPassword, $email, $description, $role);
    }


    public function initNewUser(int $idUser, String $pseudo, String $mdp, String $email, String $descriptionUser, String $roleU): void
    {
        $user = new Utilisateur($idUser, $pseudo, $mdp, $email, $descriptionUser, $roleU);
        $_SESSION['user'] = $user;
    }

    public function initUser(String $email)
    {
        $userData = $this->getUserByEmail($email);
        $user = new Utilisateur($userData['idUser'], $userData['pseudo'], $userData['mdp'], $userData['email'], $userData['descriptionU'], $userData['roleU']);
        if ($userData['imageUser'] != null)
            $user->setImage($userData['imageUser']);

        $this->getUserPlaylist($userData['idUser']);
        $this->getUserFavoris($userData['idUser']);
    }

    public function getUserByEmail(String $email)
    {
        $query = "SELECT * FROM utilisateur WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserPlaylist(int $idUser)
    {   
        $__PLAYLIST__ = new PlaylistDB();
        $user = $_SESSION['user'];

        $query = "SELECT * FROM PLAYLIST WHERE idUser = :idUser";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($stmt as $playlistData) {
            $playlist = $__PLAYLIST__->getPlaylist($playlistData['idPlaylist']);
            $user->addPlaylist($playlist);
        }
    }

    public function getUserFavoris(int $idUser):void
    {   
        $__MUSIQUE__ = new MusiqueDB();
        $user = $_SESSION['user'];

        $query = "SELECT * FROM APPRECIER WHERE idUser = :idUser";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($stmt as $favoriData) {
            $favori = getMusique($favoriData['idMusique']);
            $user->addFavori($favori);
        }
    }

}


