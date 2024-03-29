<?php

declare(strict_types=1);

namespace Modele\ModeleDB;

use PDO;
use Modele\Utilisateur;
use Modele\DataBase;
use Modele\ModeleDB\PlaylistDB;
use Modele\ModeleDB\MusiqueDB;

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
        session_start();
        $userData = $this->getUserByEmail($email);
        $user = new Utilisateur($userData['idUser'], $userData['pseudo'], $userData['mdp'], $userData['email'], $userData['descriptionU'], $userData['roleU']);
        if ($userData['imageUser'] != null)
            $user->setPdp($userData['imageUser']);
    
        $this->initUserPlaylist($user);
        $this->initUserFavoris($user);

        $_SESSION['user'] = $user;
    }

    public function getUserByEmail(String $email)
    {
        $query = "SELECT * FROM utilisateur WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function initUserPlaylist(Utilisateur $user)
    {   
        $__PLAYLIST__ = new PlaylistDB();
        $idUser = $user->getIdUser();

        $query = "SELECT * FROM PLAYLIST WHERE idUser = :idUser";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $stmt->execute();
        $playlists = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($playlists as $playlistData) {
            $playlist = $__PLAYLIST__->getPlaylist($playlistData['idPlaylist']);
            $user->addPlaylist($playlist);
        }
    }

    public function initUserFavoris(Utilisateur $user):void
    {
        $__MUSIQUE__ = new MusiqueDB();
        $idUser = $user->getIdUser();
    
        $query = "SELECT * FROM APPRECIER WHERE idUser = :idUser";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $stmt->execute();
        $favorisData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($favorisData as $favoriData) {
            $favori = $__MUSIQUE__->getMusique($favoriData['idMusique']);
            $user->addFavoris($favori);
        }
    }

    public function updateUser(Utilisateur $user)
    {
        $query = "UPDATE utilisateur SET pseudo = :pseudo, email = :email, mdp = :mdp, roleU = :roleU, descriptionU = :descriptionU, imageUser = :imageUser WHERE idUser = :idUser";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":pseudo", $user->getPseudo(), PDO::PARAM_STR);
        $stmt->bindParam(":email", $user->getEmail(), PDO::PARAM_STR);
        $stmt->bindParam(":mdp", $user->getMdp(), PDO::PARAM_STR);
        $stmt->bindParam(":roleU", $user->getRoleU(), PDO::PARAM_STR);
        $stmt->bindParam(":descriptionU", $user->getDescriptionU(), PDO::PARAM_STR);
        $stmt->bindParam(":imageUser", $user->getImage(), PDO::PARAM_STR);
        $stmt->bindParam(":idUser", $user->getIdUser(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function addFavoris(int $idUser, int $idMusique)
    {
        $query = "INSERT INTO APPRECIER (idUser, idMusique) VALUES (:idUser, :idMusique)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $stmt->bindParam(":idMusique", $idMusique, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function removeFavoris(int $idUser, int $idMusique)
    {
        $query = "DELETE FROM APPRECIER WHERE idUser = :idUser AND idMusique = :idMusique";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $stmt->bindParam(":idMusique", $idMusique, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteUser(int $idUser)
    {
        $query = "DELETE FROM UTILISATEUR WHERE idUser = :idUser";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function addPlaylist(Playlist $playlist)
    {
        $query = "INSERT INTO PLAYLIST (nomPlaylist, idUser) VALUES (:nomPlaylist, :idUser)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":nomPlaylist", $playlist->getNomPlaylist(), PDO::PARAM_STR);
        $stmt->bindParam(":idUser", $playlist->getIdUser(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function removePlaylist(int $idPlaylist)
    {
        $query = "DELETE FROM PLAYLIST WHERE idPlaylist = :idPlaylist";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idPlaylist", $idPlaylist, PDO::PARAM_INT);
        $stmt->execute();

        $query = "DELETE FROM CONTENIR WHERE idPlaylist = :idPlaylist";
    }

    public function addNoteAlbum(int $idUser, int $idAlbum, int $note)
    {
        $query = "INSERT INTO NOTER (idUser, idAlbum, note) VALUES (:idUser, :idAlbum, :note)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $stmt->bindParam(":idAlbum", $idAlbum, PDO::PARAM_INT);
        $stmt->bindParam(":note", $note, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getNote(int $idUser, int $idAlbum)
    {
        $query = "SELECT note FROM NOTER WHERE idUser = :idUser AND idAlbum = :idAlbum";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $stmt->bindParam(":idAlbum", $idAlbum, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateNoteAlbum(int $idUser, int $idAlbum, int $note)
    {
        $query = "UPDATE NOTER SET note = :note WHERE idUser = :idUser AND idAlbum = :idAlbum";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":note", $note, PDO::PARAM_INT);
        $stmt->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $stmt->bindParam(":idAlbum", $idAlbum, PDO::PARAM_INT);
        $stmt->execute();
    }


    public function getMusique(int $idMusique){
        $__MUSIQUE__ = new MusiqueDB();
        return $__MUSIQUE__->getMusique($idMusique);
    }

    public function isFavoris(int $idUser, int $idMusique): bool
    {
        $query = "SELECT * FROM APPRECIER WHERE idUser = :idUser AND idMusique = :idMusique";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $stmt->bindParam(":idMusique", $idMusique, PDO::PARAM_INT);
        $stmt->execute();

        if($stmt->fetch(PDO::FETCH_ASSOC))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function isNoteExist(int $idUser, int $idAlbum): bool
    {
        $query = "SELECT * FROM NOTER WHERE idUser = :idUser AND idAlbum = :idAlbum";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $stmt->bindParam(":idAlbum", $idAlbum, PDO::PARAM_INT);
        $stmt->execute();

        if($stmt->fetch(PDO::FETCH_ASSOC))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function addAdmin(){
        $hashedPassword = password_hash("admin", PASSWORD_DEFAULT);
        $role = "Admin";
        $description = "Administrateur";
        $pseudo = "admin";
        $email = "admin@admin";

        $query = "INSERT INTO utilisateur (pseudo, email, mdp, roleU, descriptionU) VALUES (:pseudo, :email, :mdp, :roleU, :descriptionU)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":mdp", $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(":roleU", $role, PDO::PARAM_STR);
        $stmt->bindParam(":descriptionU", $description, PDO::PARAM_STR);
        $stmt->execute();

    }
}


