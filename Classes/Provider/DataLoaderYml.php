<?php

declare(strict_types=1);

namespace Classes\Provider;

use Modele\ModeleDB\AlbumDB;
use Modele\ModeleDB\GenreDB;
use Modele\ModeleDB\ArtisteDB;
require_once __DIR__ . '/../Modele/ModeleDB/AlbumDB.php';
require_once __DIR__ . '/../Modele/ModeleDB/GenreDB.php';
require_once __DIR__ . '/../Modele/ModeleDB/ArtisteDB.php';
use Modele\DataBase;
use PDO;
require_once __DIR__ . '/../Modele/DataBase.php';

class DataLoaderYml
{
    private $pdo;
    private $genreDB;
    private $artisteDB;
    private $albumDB;

    public function __construct()
    {
        $this->pdo = DataBase::getInstance();
        $this->genreDB = new GenreDB();
        $this->artisteDB = new ArtisteDB();
        $this->albumDB = new AlbumDB();
    }

    public function loadData(string $yamlFilePath)
    {
        $lines = file($yamlFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
        $i = 0;
        while ($i < count($lines)) {
            $elem = explode(':', $lines[$i], 2);
            if ($elem[0] == '- by') {
                $nomArtiste = substr($lines[$i], 6);
                $i++;
                $entryId = substr($lines[$i],11);
                $i++;
                $genres = substr($lines[$i], 10);
                $genres = substr($genres, 0, -1);
                if ($genres == "") {
                    $genres = "null";
                }
                $i++;
                $imageAlbum = substr($lines[$i], 7);
                $i++;
                $parent = substr($lines[$i], 10);
                $i++;
                $releaseYear = substr($lines[$i], 15);
                $i++;
                $nomAlbum = substr($lines[$i], 9);
                $i++;
                
                $this->artisteDB->addArtiste($nomArtiste);
                $this->artisteDB->addArtiste($parent);
                $idArtiste = $this->artisteDB->getArtisteIdByName($nomArtiste);

                $this->albumDB->addAlbum($idArtiste, $nomAlbum, (int)$entryId, (int)$releaseYear, $imageAlbum);
            
                $genresArray = explode(",", $genres);
                foreach ($genresArray as $nomGenre) {
                    $nomGenre = trim($nomGenre);
                    $this->genreDB->addGenre($nomGenre);
                    $idGenre = $this->genreDB->getGenreIdByName($nomGenre);
                    $this->albumDB->lierGenre((int)$entryId, $idGenre);
                }
            }
        }
        return "Data loaded successfully!";
    }
}