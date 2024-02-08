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
            $image = ;
            $genres = ;
            $pistes = ;

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