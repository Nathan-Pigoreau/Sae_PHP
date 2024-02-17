<?php

declare(strict_types=1);

namespace Modele\ModeleDB;

use PDO;
use Modele\Album;
use Modele\DataBase;
use Modele\Musique;
use Modele\Genre;
use Modele\ModeleDB\GenreDB;
use Modele\ModeleDB\MusiqueDB;

final class AlbumDB
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DataBase::getInstance();
    }

    public function getAlbums()
    {   
        $query = "SELECT * FROM ALBUM";
        $stmt = $this->db->query($query);
        $albumsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $albums = [];
    
        foreach ($albumsData as $albumData)
        {
            $idAlbum = $albumData['idAlbum'];
            $album = $this->getAlbum($idAlbum);
            array_push($albums, $album);
        }
    
        return $albums;
    }

    public function updateAlbum(Album $album)
    {
        $query = "UPDATE ALBUM SET idArtiste = :idArtiste, nomAlbum = :nomAlbum, idAlbum = :idAlbum, releaseYear :releaseYear WHERE idAlbum = :idAlbum";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idArtiste', $album->getIdArtiste());
        $stmt->bindParam(':nomAlbum', $album->getNomAlbum());
        $stmt->bindParam(':idAlbum', $album->getIdAlbum());
        $stmt->bindParam(':releaseYear', $album->getReleaseYear());
        $stmt->execute();

    }

    public function deleteAlbum(int $idAlbum)
    {
        $query = "DELETE FROM ALBUM WHERE idAlbum = :idAlbum";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idAlbum', $idAlbum);
        $stmt->execute();
    }

    public function getAlbum($idAlbum)
    {

        $query = "SELECT * FROM ALBUM WHERE idAlbum = :idAlbum";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idAlbum', $idAlbum);
        $stmt->execute();
        $albumData = $stmt->fetch(PDO::FETCH_ASSOC);

        $idAlbum = intval($idAlbum);
        /** @var Genre[] */
        $genres = $this->getGenresAlbum($idAlbum);
        /** @var Musique[] */
        $musiques = $this->getMusiquesAlbum($idAlbum);
        

        $album = new Album($albumData['idAlbum'], $albumData['idArtiste'], $albumData['nomAlbum'], $albumData['releaseYear'],  $albumData['imageAlbum']);
        //Initialisation des genres
        foreach ($genres as $genre)
        {
            $album->initGenre($genre);
        }
        //Initialisation des pistes
        foreach ($musiques as $musique)
        {
            $album->initMusique($musique);
        }

        return $album;
    }

    public function getMusiquesAlbum(int $idAlbum)
    {
        $__MUSIQUE__ = new MusiqueDB();

        $query = "SELECT idMusique FROM MUSIQUE WHERE idAlbum = :idAlbum";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idAlbum', $idAlbum);
        $stmt->execute();
        $musiquesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $musiques = [];
        foreach ($musiquesData as $musiqueData)
        {
            $musique = $__MUSIQUE__->getMusique($musiqueData['idMusique']);
            array_push($musiques, $musique);
        }
        return $musiques;
    }

    public function getGenresAlbum(int $idAlbum)
    {
        $__GENRE__ = new GenreDB();

        $query = "SELECT idGenre FROM APPARTENIR WHERE idAlbum = :idAlbum";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idAlbum', $idAlbum);
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

    public function addMusiqueAlbum(int $idAlbum, int $idMusique)
    {
        $query = "UPDATE MUSIQUE SET idAlbum = :idAlbum WHERE idMusique = :idMusique";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idAlbum', $idAlbum);
        $stmt->bindParam(':idMusique', $idMusique);
        $stmt->execute();
    }

    public function removeMusiqueAlbum(int $idAlbum, int $idMusique)
    {
        $query = "UPDATE MUSIQUE SET idAlbum = NULL WHERE idMusique = :idMusique";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idMusique', $idMusique);
        $stmt->execute();
    }

    public function getNomArtiste(int $idArtiste): string
    {
        $query = "SELECT nomA FROM ARTISTE WHERE idArtiste = :idArtiste";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idArtiste', $idArtiste);
        $stmt->execute();
        $artisteData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $artisteData['nomA'];
    }

    public function albumExists(String $nomAlbum): bool
    {
        $query = "SELECT * FROM ALBUM WHERE nomAlbum = :nomAlbum";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nomAlbum', $nomAlbum);
        $stmt->execute();
        $albumData = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($albumData)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function albumExistsId(int $idAlbum): bool
    {
        $query = "SELECT * FROM ALBUM WHERE idAlbum = :idAlbum";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idAlbum', $idAlbum);
        $stmt->execute();
        $albumData = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($albumData) {
            return true;
        } else {
            return false;
        }
    }

    public function addAlbum(int $idArtiste, String $nomAlbum, int $idAlbum , int $releaseYear, String $imageAlbum)
    {   
        if (!$this->albumExistsId($idAlbum)){
            $query = "INSERT INTO ALBUM (idArtiste, nomAlbum, idAlbum, imageAlbum, releaseYear) VALUES (:idArtiste, :nomAlbum, :idAlbum, :imageAlbum, :releaseYear)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':idAlbum', $idAlbum);
            $stmt->bindParam(':idArtiste', $idArtiste);
            $stmt->bindParam(':nomAlbum', $nomAlbum);
            $stmt->bindParam(':imageAlbum', $imageAlbum);
            $stmt->bindParam(':releaseYear', $releaseYear);
            $stmt->execute();
        }
    }

    public function lierGenre(int $idAlbum, int $idGenre)
    {
        $query = "INSERT INTO APPARTENIR (idAlbum, idGenre) VALUES (:idAlbum, :idGenre)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idAlbum', $idAlbum);
        $stmt->bindParam(':idGenre', $idGenre);
        $stmt->execute();
    }

    public function filtreAlbumGenre(int $idGenre){
        $query = "SELECT * FROM ALBUM WHERE idAlbum IN (SELECT idAlbum FROM APPARTENIR WHERE idGenre = :idGenre)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idGenre', $idGenre);
        $stmt->execute();
        $albumsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $albums = [];
        foreach ($albumsData as $albumData)
        {
            $album = $this->getAlbum($albumData['idAlbum']);
            array_push($albums, $album);
        }
        return $albums;
    }

    public function filtreAlbumYear(int $year){
        $query = "SELECT * FROM ALBUM WHERE releaseYear = :year";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':year', $year);
        $stmt->execute();
        $albumsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $albums = [];
        foreach ($albumsData as $albumData)
        {
            $album = $this->getAlbum($albumData['idAlbum']);
            array_push($albums, $album);
        }
        return $albums;
    }

    public function filtreAlbum(int $idGenre, int $year){
        $query = "SELECT * FROM ALBUM WHERE idAlbum IN (SELECT idAlbum FROM APPARTENIR WHERE idGenre = :idGenre) AND releaseYear = :year";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idGenre', $idGenre);
        $stmt->bindParam(':year', $year);
        $stmt->execute();
        $albumsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $albums = [];
        foreach ($albumsData as $albumData)
        {
            $album = $this->getAlbum($albumData['idAlbum']);
            array_push($albums, $album);
        }
        return $albums;
    }

    public function isExist($idAlbum): bool
    {
        $query = "SELECT * FROM ALBUM WHERE idAlbum = :idAlbum";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idAlbum', $idAlbum);
        $stmt->execute();

        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            return true;
        } else {
            return false;
        }
    }
}