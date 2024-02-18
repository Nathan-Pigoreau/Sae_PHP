<?php

declare(strict_types=1);

namespace Modele\ModeleDB;

use PDO;

use Modele\DataBase;
use Modele\Musique;
use Modele\ModeleDB\GenreDB;
use Modele\ModeleDB\AlbumDB;

final class MusiqueDB
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DataBase::getInstance();
    }

    public function getMusique(int $idMusique)
    {
        $genres = $this->getGenresMusique($idMusique);

        $query = "SELECT * FROM MUSIQUE WHERE idMusique = :idMusique";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idMusique', $idMusique);
        $stmt->execute();
        $musiqueData = $stmt->fetch(PDO::FETCH_ASSOC);
        $musique = new Musique($musiqueData['idMusique'], $musiqueData['idArtiste'], $musiqueData['nomMusique'], $musiqueData['releaseYear'],$musiqueData['imageMusique'], $musiqueData['nbVues']);
        if($musiqueData['idAlbum'])
        {
            $musique->setIdAlbum($musiqueData['idAlbum']);
        }
        foreach ($genres as $genre)
        {
            $musique->addGenre($genre);
        }

        return $musique;
    }

    public function getGenresMusique($idMusique)
    {
        $__GENRE__ = new GenreDB();

        $query = "SELECT idGenre FROM CLASSER WHERE idMusique = :idMusique";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idMusique', $idMusique);
        $stmt->execute();
        $genresData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $genres = [];
        foreach ($genresData as $genreData)
        {
            $genre = $__GENRE__->getGenre($genreData['idGenre']);
            array_push($genres, $genre);
        }
        return $genres;
    }

    public function musiqueExists(String $nomMusique): bool
    {
        $query = "SELECT * FROM MUSIQUE WHERE nomMusique = :nomMusique";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nomMusique', $nomMusique);
        $stmt->execute();
        $musiqueData = $stmt->fetch(PDO::FETCH_ASSOC);
        if($musiqueData)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function isExist(int $idMusique): bool
    {
        $query = "SELECT * FROM MUSIQUE WHERE idMusique = :idMusique";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idMusique', $idMusique);
        $stmt->execute();
        $musiqueData = $stmt->fetch(PDO::FETCH_ASSOC);
        if($musiqueData)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getNomArtiste($idArtiste): string
    {
        $query = "SELECT nomA FROM ARTISTE WHERE idArtiste = :idArtiste";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idArtiste', $idArtiste);
        $stmt->execute();
        $artisteData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $artisteData['nomA'];
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

    public function getMusiqueAlbum($idAlbum)
    {
        $__ALBUM__ = new AlbumDB();
        return $__ALBUM__->getAlbum($idAlbum);
    }

    public function addMusique($idArtiste, $nomMusique, $releaseYear, $imageMusique, $idAlbum)
    {
        $query = "INSERT INTO MUSIQUE (idArtiste, nomMusique, releaseYear, imageMusique, idAlbum) VALUES (:idArtiste, :nomMusique, :releaseYear, :imageMusique, :idAlbum)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idArtiste', $idArtiste);
        $stmt->bindParam(':nomMusique', $nomMusique);
        $stmt->bindParam(':releaseYear', $releaseYear);
        $stmt->bindParam(':imageMusique', $imageMusique);
        $stmt->bindParam(':idAlbum', $idAlbum);
        $stmt->execute();
    }

    public function updateMusique(Musique $musique)
    {
        $query = "UPDATE MUSIQUE SET idAlbum = :idAlbum, idArtiste = :idArtiste, nomMusique = :nomMusique, releaseYear = :releaseYear, imageMusique = :imageMusique, nbVues = :nbVues WHERE idMusique = :idMusique";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idAlbum', $musique->getIdAlbum());
        $stmt->bindParam(':idArtiste', $musique->getIdArtiste());
        $stmt->bindParam(':nomMusique', $musique->getNomMusique());
        $stmt->bindParam(':releaseYear', $musique->getReleaseYear());
        $stmt->bindParam(':imageMusique', $musique->getImage());
        $stmt->bindParam(':nbVues', $musique->getNbVues());
        $stmt->bindParam(':idMusique', $musique->getIdMusique());
        $stmt->execute();
    }

    public function getMusiques(){
        $query = "SELECT * FROM MUSIQUE";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $musiquesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $musiques = [];
        foreach ($musiquesData as $musiqueData)
        {
            $musique = new Musique($musiqueData['idMusique'], $musiqueData['idArtiste'], $musiqueData['nomMusique'], $musiqueData['releaseYear'], $musiqueData['imageMusique'], $musiqueData['nbVues']);
            if($musiqueData['idAlbum'])
            {
                $musique->setIdAlbum($musiqueData['idAlbum']);
            }
            array_push($musiques, $musique);
        }
        return $musiques;
    }

    public function displayMusiquesAdmin(): string
    {
        $musiques = $this->getMusiques();
        $html = "<div class='musiques'>";
        foreach ($musiques as $musique) {
            $html .= $musique->renderAdmin();
        }
        $html .= "</div>";
    
        $html .= '<button onclick="showAddMusiqueForm()">Ajouter une nouvelle musique</button>';
    
        $html .= '<div id="addMusiqueFormContainer" style="display:none;">';
        $html .= '<h2>Ajouter une nouvelle musique</h2>';
        $html .= '<form id="addMusiqueForm" action="/Classes/Controller/controllerAddMusique.php" method="post" enctype="multipart/form-data">';
        $html .= '<label for="newMusiqueName">Nom de la musique:</label>';
        $html .= '<input type="text" id="newMusiqueName" name="newMusiqueName" required>';
        $html .= '<label for="newMusiqueReleaseYear">Date de sortie:</label>';
        $html .= '<input type="text" id="newMusiqueReleaseYear" name="newMusiqueReleaseYear" required>';
        $html .= '<label for="newMusiqueArtist">Artiste:</label>';
        $html .= '<input type="text" id="newMusiqueArtist" name="newMusiqueArtist" required>';
    
        $html .= '<label for="newMusiqueImage">Image de la musique:</label>';
        $html .= '<input type="file" id="newMusiqueImage" name="newMusiqueImage" accept="image/*" style="display: none;">';
        $html .= '<button type="button" onclick="triggerFileInput()">Sélectionner une image</button>';
    
        $html .= '<input type="submit" value="Ajouter">';
        $html .= '</form>';
        $html .= '</div>';
    
        $html .= '<script>
                    function showAddMusiqueForm() {
                        var addMusiqueFormContainer = document.getElementById("addMusiqueFormContainer");
                        addMusiqueFormContainer.style.display = "block";
                    }
                
                    function triggerFileInput() {
                        document.getElementById("newMusiqueImage").click();
                    }
                  </script>';
                
        return $html;
    }
}