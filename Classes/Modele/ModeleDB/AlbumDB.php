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
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
        $idAlbum = $album->getIdAlbum();
        $this->deleteAppartenance((int)$idAlbum);
        $query = "UPDATE ALBUM SET idArtiste = :idArtiste, nomAlbum = :nomAlbum, releaseYear = :releaseYear WHERE idAlbum = :idAlbum";
        $stmt = $this->db->prepare($query);
        $idArtiste = $album->getIdArtiste();
        $nomAlbum = $album->getNomAlbum();
        $releaseYear = $album->getReleaseYear();
        $imageAlbum = $album->getImage();

        $stmt->bindParam(':idArtiste', $idArtiste, PDO::PARAM_INT);
        $stmt->bindParam(':nomAlbum', $nomAlbum, PDO::PARAM_STR);
        $stmt->bindParam(':releaseYear', $releaseYear, PDO::PARAM_INT);
        $stmt->bindParam(':idAlbum', $idAlbum, PDO::PARAM_INT);
        $stmt->execute();

        $genres = $album->getGenres();
        foreach ($genres as $genre)
        {
            $idGenre = $genre->getIdGenre();
            $this->lierGenre($idAlbum, $idGenre);
        }
    }

    public function deleteAppartenance(int $idAlbum)
{
    $query = "DELETE FROM APPARTENIR WHERE idAlbum = :idAlbum";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':idAlbum', $idAlbum, PDO::PARAM_INT);
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

    public function addAlbumWithoutId(int $idArtiste, String $nomAlbum, int $releaseYear, String $imageAlbum)
    {
        if (!$this->albumExists($nomAlbum)) {
            $query = "INSERT INTO ALBUM (idArtiste, nomAlbum, imageAlbum, releaseYear) VALUES (:idArtiste, :nomAlbum, :imageAlbum, :releaseYear)";
            $stmt = $this->db->prepare($query);
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

    public function getIdAlbumByName(String $nomAlbum)
    {
        $query = "SELECT idAlbum FROM ALBUM WHERE nomAlbum = :nomAlbum";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nomAlbum', $nomAlbum);
        $stmt->execute();
        $idAlbum = $stmt->fetch(PDO::FETCH_ASSOC);
        return $idAlbum['idAlbum'];
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

    public function getMoyenneNote(int $idAlbum): float
    {
        $query = "SELECT AVG(note) as moyenne FROM NOTER WHERE idAlbum = :idAlbum";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idAlbum", $idAlbum, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return floatval($result['moyenne']);
    }
    public function displayAlbums(): String
    {
        $albums = $this->getAlbums();
        $html = "<div class='albums'>";
        foreach ($albums as $album)
        {
            $html .= $album->render();
        }
        $html .= "</div>";

        return $html;
    }

    public function displayAlbumsAdmin(): String
    {
        $albums = $this->getAlbums();
        $html = "<div class='albums'>";
        foreach ($albums as $album)
        {
            $html .= $album->renderAdmin();
        }
        $html .= "</div>";

        $html .= '<button onclick="showAddAlbumForm()">Ajouter un nouvel album</button>';

        $html .= '<div id="addAlbumFormContainer" style="display:none;">';
        $html .= '<h2>Ajouter un nouvel album</h2>';
        $html .= '<form id="addAlbumForm" action="/Classes/Controller/controllerAddAlbum.php" method="post" enctype="multipart/form-data">';
        $html .= '<label for="newAlbumName">Nom de l\'album:</label>';
        $html .= '<input type="text" id="newAlbumName" name="newAlbumName" required>';
        $html .= '<label for="newAlbumReleaseYear">Date de sortie:</label>';
        $html .= '<input type="text" id="newAlbumReleaseYear" name="newAlbumReleaseYear" required>';
        $html .= '<label for="newAlbumArtist">Artiste:</label>';
        $html .= '<input type="text" id="newAlbumArtist" name="newAlbumArtist" required>';

        $html .= '<label for="newAlbumImage">Image de l\'album:</label>';
        $html .= '<input type="file" id="newAlbumImage" name="newAlbumImage" accept="image/*" style="display: none;">';
        $html .= '<button type="button" onclick="triggerFileInput()">Sélectionner une image</button>';

        $html .= '<input type="submit" value="Ajouter">';
        $html .= '</form>';
        $html .= '</div>';

        $html .= '<script>
                    function showAddAlbumForm() {
                        var addAlbumFormContainer = document.getElementById("addAlbumFormContainer");
                        addAlbumFormContainer.style.display = "block";
                    }

                    function triggerFileInput() {
                        document.getElementById("newAlbumImage").click();
                    }
                  </script>';

        return $html;
    }

    function getIdArtiste(String $nomArtiste)
    {
        $query = "SELECT idArtiste FROM ARTISTE WHERE nomA = :nomArtiste";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nomArtiste', $nomArtiste);
        $stmt->execute();
        $idArtiste = $stmt->fetch(PDO::FETCH_ASSOC);
        return $idArtiste['idArtiste'];
    }

    function getGenres(){
        $__GENRE__ = new GenreDB();
        return $__GENRE__->getGenres();
    }
}