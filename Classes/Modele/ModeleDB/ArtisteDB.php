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

    public function getArtiste(int $idArtiste)
    {
        $albums = $this->getAlbumsArtiste($idArtiste);
        $musiques = $this->getMusiquesArtiste($idArtiste);

        $query = "SELECT * FROM ARTISTE WHERE idArtiste = :idArtiste";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idArtiste', $idArtiste);
        $stmt->execute();
        $artisteData = $stmt->fetch(PDO::FETCH_ASSOC);
        $artiste = new Artiste(
            $artisteData['idArtiste'],
            $artisteData['nomA'],
            $artisteData['prenomA'],
            isset($artisteData['imageArtiste']) ? $artisteData['imageArtiste'] : '',
            $artisteData['descriptionA'],
            $artisteData['nbAuditeurs']
        );
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
        $query = "UPDATE ARTISTE SET nomA = :nomA, prenomA = :prenomA, descriptionA = :descriptionA, nbAuditeurs = :nbAuditeurs WHERE idArtiste = :idArtiste";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nomA', $artiste->getNomA());
        $stmt->bindParam(':prenomA', $artiste->getPrenomA());
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

    public function ajouterArtiste(String $nomA, String $prenomA, String $descriptionA): void
    {
        $query = "INSERT INTO ARTISTE (nomA, prenomA, descriptionA) VALUES (:nomA, :prenomA, :descriptionA)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nomA', $nomA);
        $stmt->bindParam(':prenomA', $prenomA);
        $stmt->bindParam(':descriptionA', $descriptionA);
        $stmt->execute();
    }

    public function displayArtistesAdmin(): String
    {
        $artistes = $this->getArtistes();
        $html = "<div class='artistes'>";
        foreach ($artistes as $artiste)
        {
            $html .= $artiste->renderAdmin();
        }
        $html .= "</div>";

        $html .= '<button onclick="showAddArtisteForm()">Ajouter un nouvel artiste</button>';

        $html .= '<div id="addArtisteFormContainer" style="display:none;">';
        $html .= '<h2>Ajouter un nouvel artiste</h2>';
        $html .= '<form id="addArtisteForm" action="/Classes/Controller/controllerAddArtiste.php" method="post">';
        $html .= '<label for="newArtisteName">Nom de l\'artiste:</label>';
        $html .= '<input type="text" id="newArtisteName" name="newArtisteName" required>';
        $html .= '<label for="newArtisteFirstName">Prénom de l\'artiste:</label>';
        $html .= '<input type="text" id="newArtisteFirstName" name="newArtisteFirstName" required>';
        $html .= '<label for="newArtisteDescription">Description de l\'artiste:</label>';
        $html .= '<textarea id="newArtisteDescription" name="newArtisteDescription" required></textarea>';

        $html .= '<input type="submit" value="Ajouter">';
        $html .= '</form>';
        $html .= '</div>';

        $html .= '<script>
                    function showAddArtisteForm() {
                        var addArtisteFormContainer = document.getElementById("addArtisteFormContainer");
                        addArtisteFormContainer.style.display = "block";
                    }
                  </script>';

        return $html;
    }

    public function getArtistes(){
        $query = "SELECT * FROM ARTISTE";
        $stmt = $this->db->query($query);
        $artistesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $artistes = [];
        foreach ($artistesData as $artisteData)
        {
            $artistes[] = new Artiste(
                $artisteData['idArtiste'],
                $artisteData['nomA'],
                $artisteData['prenomA'],
                isset($artisteData['imageArtiste']) ? $artisteData['imageArtiste'] : '',
                $artisteData['descriptionA'],
                $artisteData['nbAuditeurs']
            );
        }
        return $artistes;
    }

}
