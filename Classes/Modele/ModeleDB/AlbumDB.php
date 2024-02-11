<?php

declare(strict_types=1);

namespace Modele\ModeleDB;

use PDO;
use Modele\Album;
use Modele\DataBase;
use Modele\ModeleDB\GenreDB;
use Modele\ModeleDB\MusiqueDB;
use Modele\ModeleDB\ImageDB;

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
            $this->getAlbum($albumData['idAlbum']);
        }
    }

    public function updateAlbum(Album $album)
    {
        $query = "UPDATE ALBUM SET idArtiste = :idArtiste, nomAlbum = :nomAlbum, date = :date WHERE idAlbum = :idAlbum";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idArtiste', $album->getIdArtiste());
        $stmt->bindParam(':nomAlbum', $album->getNomAlbum());
        $stmt->bindParam(':date', $album->getRealeaseYear());
        $stmt->bindParam(':idAlbum', $album->getIdAlbum());
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
        /** @var Genre[] */
        $genres = $this->getGenresAlbum($albumData['idAlbum']);
        /** @var Musique[] */
        $musiques = $this->getMusiquesAlbum($idAlbum);
        /** @var Image */
        $image = $this->getImageAlbum($idAlbum);
        
        $album = new Album($albumData['idAlbum'], $albumData['idArtiste'], $albumData['nomAlbum'], $albumData['date']);
        //Initialisation des genres
        foreach ($genres as $genre)
        {
            $album->addGenre($genre['idGenre']);
        }
        //Initialisation des pistes
        foreach ($musiques as $musique)
        {
            $album->addMusique($musique['idMusique']);
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

    public function getGenresAlbum(int $idAlbum): arrayGenre
    {
        $__GENRE__ = new GenreDB();

        $query = "SELECT idGenre FROM APARTENIR WHERE idAlbum = :idAlbum";
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


}