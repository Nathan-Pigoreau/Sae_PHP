<?php

declare(strict_types=1);

namespace Modele\ModeleDB;

use PDO;
use Modele\Artiste;
use Modele\DataBase;
use Modele\ModeleDB\AlbumDB;
use Modele\ModeleDB\MusiqueDB;


final class ArtisteDB
{

    private PDO $db;

    public function __construct()
    {
        $this->db = DataBase::getInstance();
    }

    public function getArtiste($idArtiste)
    {
        /**@var Albums */
        $albums = $this->getAlbumsArtiste();
        /**@var Musiques */
        $musiques = $this->getMusiquesArtiste();

        $query = "SELECT * FROM ARTISTE WHERE idArtiste = :idArtiste";
        $stmt = $this->db->query($query);
        $artisteData = $stmt->fetch(PDO::FETCH_ASSOC);

        new Artiste($artisteData['idArtiste'], $artisteData['nomA'], $artisteData['prenomA'], $artisteData['imageArtiste'], $artisteData['descriptionA'], $artisteData['nbAuditeurs']);

        foreach ($albums as $album)
        {
            $artiste->addAlbum($album);
        }

        foreach ($musiques as $musique)
        {
            $artiste->addMusique($musique);
        }

        return $artiste;
    }
        


    public function getAlbumsArtiste(int $idArtiste)
    {
        $__ALBUM__ = new AlbumDB();

        $query = "SELECT * FROM ALBUM WHERE idArtiste = :idArtiste";
        $stmt = $this->db->query($query);
        $stmt->bindParam(':idArtiste', $idArtiste);
        $stmt->execute();
        $albumsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $albums = [];

        foreach ($albumsData as $albumData)
        {
            $albums[] = $__ALBUM__->getAlbum($albumData['idAlbum']);
        }

        return $albums;
    }

    public function getMusiquesArtiste(int $idArtiste)
    {
        $__MUSIQUE__ = new MusiqueDB();

        $query = "SELECT * FROM MUSIQUE WHERE idArtiste = :idArtiste";
        $stmt = $this->db->query($query);
        $stmt->bindParam(':idArtiste', $idArtiste);
        $stmt->execute();
        $musiquesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $musiques = [];

        foreach ($musiquesData as $musiqueData)
        {
            $musiques[] = $__MUSIQUE__->getMusique($musiqueData['idMusique']);
        }

        return $musiques;
    }

    public function deleteArtiste(int $idArtiste)
    {
        $query = "DELETE FROM ARTISTE WHERE idArtiste = :idArtiste";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idArtiste', $idArtiste);
        $stmt->execute();
    }

    public function updateArtiste(Artiste $artiste)
    {
        $query = "UPDATE ARTISTE SET nomA = :nomA, prenomA = :prenomA, imageArtiste = :imageArtiste, descriptionA = :descriptionA, nbAuditeurs = :nbAuditeurs WHERE idArtiste = :idArtiste";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nomA', $artiste->getNomA());
        $stmt->bindParam(':prenomA', $artiste->getPrenomA());
        $stmt->bindParam(':imageArtiste', $artiste->getImageArtiste());
        $stmt->bindParam(':descriptionA', $artiste->getDescriptionA());
        $stmt->bindParam(':nbAuditeurs', $artiste->getNbAuditeurs());
        $stmt->bindParam(':idArtiste', $artiste->getIdArtiste());
        $stmt->execute();
    }

    public function removeAlbumArtiste(int $idArtiste, int $idAlbum)
    {
        $query = "DELETE FROM ALBUM WHERE idArtiste = :idArtiste AND idAlbum = :idAlbum";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idArtiste', $idArtiste);
        $stmt->bindParam(':idAlbum', $idAlbum);
        $stmt->execute();
    }

    public function removeMusiqueArtiste(int $idArtiste, int $idMusique)
    {
        $query = "DELETE FROM MUSIQUE WHERE idArtiste = :idArtiste AND idMusique = :idMusique";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idArtiste', $idArtiste);
        $stmt->bindParam(':idMusique', $idMusique);
        $stmt->execute();
    }
    public function getArtisteIdByName($nomA) : int
    {
        $query = "SELECT idArtiste FROM ARTISTE WHERE nomA = :nomA";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nomA', $nomA);
        $stmt->execute();
        $artisteData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $artisteData['idArtiste'];
    }

    public function artisteExistsId(int $idArtiste): bool
    {
        $query = "SELECT * FROM ARTISTE WHERE idArtiste = :idArtiste";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idArtiste', $idArtiste);
        $stmt->execute();
        $artisteData = $stmt->fetch(PDO::FETCH_ASSOC);
        if($artisteData)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function artisteExists(String $nomArtiste): bool
    {
        $query = "SELECT * FROM ARTISTE WHERE nomA = :nomArtiste";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nomArtiste', $nomArtiste);
        $stmt->execute();
        $artisteData = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($artisteData) {
            return true;
        } else {
            return false;
        }
    }
    public function addArtiste(String $nomA): void
    {   
        if(!$this->artisteExists($nomA)){
            $query = "INSERT INTO ARTISTE (nomA) VALUES (:nomA)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nomA', $nomA);
            $stmt->execute();
        }
    }

}
