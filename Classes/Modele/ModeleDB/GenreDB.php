<?php

declare(strict_types=1);

namespace Modele\ModeleDB;

use PDO;
use Modele\Genre;
Use Modele\DataBase;

final class GenreDB
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DataBase::getInstance();
    }

    public function getGenre($idGenre)
    {
        $query = "SELECT * FROM GENRE WHERE idGenre = :idGenre";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idGenre', $idGenre);
        $stmt->execute();
        $genreData = $stmt->fetch(PDO::FETCH_ASSOC);
        $genre = new Genre($genreData['idGenre'], $genreData['nomGenre']);
        return $genre;
    }

    public function getGenres()
    {
        $query = "SELECT * FROM GENRE";
        $stmt = $this->db->query($query);
        $genresData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $genres = [];
        foreach ($genresData as $genreData)
        {
            $genre = new Genre($genreData['idGenre'], $genreData['nomGenre']);
            array_push($genres, $genre);
        }
        return $genres;
    }

}