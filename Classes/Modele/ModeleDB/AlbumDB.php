<?php

declare(strict_types=1);

namespace Modele\ModeleDB;

use PDO;
use Modele\Album;
use Modele\DataBase;

final class AlbumDB
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DataBase::getInstance;
    }

    public function getAlbums()
    {
        $query = "SELECT * FROM ALBUM";
        $stmt = $this->db->query($query);
        $albumsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $albums = [];

        foreach ($albumsData as $albumData)
        {
            $image = $this->getImageAlbum($albumData['idAlbum']);
            $genres = $this->getGenresAlbum($albumData['idAlbum']);
            $pistes = $this->getPistesAlbum($albumData['idAlbum']);

            $album = new Album($albumData['idAlbum'], $albumData['idArtiste'], $albumData['nomAlbum'], $albumData['date']);
            //Initialisation des images
            $album->setImage($image['image']);
            //Initialisation des genres
            foreach ($genres as $genre)
            {
                $album->addGenre($genre['idGenre']);
            }
            //Initialisation des pistes

        }
    }

    public function getImageAlbum(int $idAlbum)
    {
        $query = "SELECT image FROM LIER WHERE idAlbum = :idAlbum";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idAlbum', $idAlbum);
        $stmt->execute();
        $image = $stmt->fetch(PDO::FETCH_ASSOC);
        return $image;
    }

    public function getGenresAlbum(int $idAlbum)
    {
        $query = "SELECT idGenre FROM APARTENIR WHERE idAlbum = :idAlbum";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idAlbum', $idAlbum);
        $stmt->execute();
        $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $genres;
    }

    public function getPistesAlbum(int $idAlbum)
    {
        $query = "SELECT * FROM MUSIQUE WHERE idAlbum = :idAlbum";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idAlbum', $idAlbum);
        $stmt->execute();
        $pistesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pistes = [];

        foreach ($pistesData as $pisteData)
        {
            $piste = new Musique($pisteData['idPiste'], $pisteData['idAlbum'], $pisteData['nomPiste'], $pisteData['duree']);
            $pistes[] = $piste;
        }

        return $pistes;
    }

    public function updateAlbum(Album $album)
    {
        $query = "UPDATE ALBUM
                  SET idAlbum = :idAlbum, idArtiste = :idArtiste, nomAlbum = :nomAlbum, date = :date, image = :image
                  WHERE idAlbum = :idAlbum";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idAlbum', $album->getIdAlbum());
        $stmt->bindParam(':idArtiste', $album->getIdArtiste());
        $stmt->bindParam(':nomAlbum', $album->getNomAlbum());
        $stmt->bindParam(':date', $album->getRealeaseYear());
        $stmt->execute();

    }

    public function deleteAlbum(int $idAlbum)
    {
        $query = "DELETE FROM ALBUM WHERE idAlbum = :idAlbum";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idAlbum', $idAlbum);
        $stmt->execute();
    }

}