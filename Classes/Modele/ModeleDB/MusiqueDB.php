<?php

declare(strict_types=1);

namespace Modele\ModeleDB;

use PDO;

use Modele\DataBase;
use Modele\Musique;
use Modele\ModeleDB\GenreDB;

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
        $musique = new Musique($musiqueData['idMusique'], $musiqueData['idArtiste'], $musiqueData['nomMusique'], $musiqueData['realeaseYear'],$musiqueData['imageMusique'], $nbVues['nbVues']);
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

    public function updateMusique(Musique $musique)
    {
        $query = "UPDATE MUSIQUE SET idAlbum = :idAlbum, idArtiste = :idArtiste, nomMusique = :nomMusique, realeaseYear = :realeaseYear, imageMusique = :imageMusique, nbVues = :nbVues WHERE idMusique = :idMusique";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idAlbum', $musique->getIdAlbum());
        $stmt->bindParam(':idArtiste', $musique->getIdArtiste());
        $stmt->bindParam(':nomMusique', $musique->getNomMusique());
        $stmt->bindParam(':realeaseYear', $musique->getRealeaseYear());
        $stmt->bindParam(':imageMusique', $musique->getImage());
        $stmt->bindParam(':nbVues', $musique->getNbVues());
        $stmt->bindParam(':idMusique', $musique->getIdMusique());
        $stmt->execute();
    }

}
