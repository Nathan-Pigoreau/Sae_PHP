<?php 

declare(strict_types=1);

namespace Modele;

use Modele\ModeleDB\ArtisteDB;

final class Artiste
{
    private int $idArtiste;

    private String $nomA;

    private String $prenomA;

    private String $imageArtiste;

    private String $descriptionA;

    private int $nbAuditeurs;

    /**
     * @var Album
     */
    private array $albums;

    /**
     * @var Musique
     */
     private array $musiques;

    private ArtisteDB $modelDB;

     public function __construct(int $idArtiste, String $nomA, String $prenomA, String $imageArtiste, String $descriptionA, int $nbAuditeurs)
     {
        $this->idArtiste = $idArtiste;
        $this->nomA = $nomA;
        $this->prenomA = $prenomA;
        $this->imageArtiste = $imageArtiste;
        $this->descriptionA = $descriptionA;
        $this->nbAuditeurs = $nbAuditeurs;
        $this->albums = [];
        $this->musiques = [];

        $this->modelDB = new ArtisteDB();
     }

     public function getIdArtiste(): int
     {
        return $this->idArtiste;
     }

     public function getNomA(): String
     {
        return $this->nomA;
     }

     public function getPrenomA(): String
     {
        return $this->prenomA;
     }

     public function getImageArtiste(): String
     {
        return $this->imageArtiste;
     }

     public function getDescriptionA(): String
     {
        return $this->descriptionA;
     }

     public function getNbAuditeurs(): int
     {
        return $this->nbAuditeurs;
     }

     public function getAlbums(): array
     {
        return $this->albums;
     }

     public function getMusiques(): array
     {
        return $this->musiques;
     }

     public function setNomA(String $nomA): void
     {
        $this->nomA = $nomA;
        $this->updateArtiste();
     }

     public function setPrenomA(String $prenomA): void
     {
        $this->prenomA = $prenomA;
        $this->updateArtiste();
     }

     public function setImage(String $image): void
     {
        $this->imageArtiste = $image;
        $this->updateArtiste();
     }

     public function setDescriptionA(String $descriptionA): void
     {
        $this->descriptionA = $descriptionA;
        $this->updateArtiste();
     }

     public function addNbAuditeurs(): void
     {
        $this->nbAuditeurs += 1;
        $this->updateArtiste();
     }

     public function addAlbum(Album $album): void
     {
        $this->albums[] = $album;
     }

     public function removeAlbum(int $idAlbum): void
     {
        $index = array_search($idAlbum, array_column($this->albums, 'idAlbum'));

        if ($index !== false) {
            unset($this->albums[$index]);
            $this->albums = array_values($this->albums);
            $this->modelDB->removeAlbumArtiste($this->idArtiste, $idAlbum);
        }
     }

     public function addMusique(Musique $musique): void
     {
        $this->musiques[] = $musique;
     }

     public function removeMusique(int $idMusique): void
     {
        $index = array_search($idMusique, array_column($this->musiques, 'idMusique'));

        if ($index !== false) {
            unset($this->musiques[$index]);
        }
     }

     public function updateArtiste(): void
     {
        $this->modelDB->updateArtiste($this);
     }

     public function render(): String
     {
        $html = '<div class="artiste">';
        $html .= '<img src="' . $this->imageArtiste . '" alt="Image de l\'artiste">';
        $html .= '<h2>' . $this->nomA . ' ' . $this->prenomA . '</h2>';
        $html .= '<p>' . $this->descriptionA . '</p>';
        $html .= '<p>' . $this->nbAuditeurs . ' auditeurs</p>';
        $html .= '</div>';

        return $html;
     }

     public function renderDetails(): String
     {
         $html = '<div class="artiste">';
         $html .= '<img src="'. '/Static/images/'. $this->imageArtiste . '" alt="Photo artiste">';
         $html .= '<h2>' . $this->nomA . ' ' . $this->prenomA . '</h2>';
         $html .= '<p>' . $this->descriptionA . '</p>';
         $html .= '<p>' . $this->nbAuditeurs . ' auditeurs</p>';
         $html .= '<h3>Albums</h3>';
         $html .= '<ul>';
         foreach ($this->albums as $album)
         {
               $html .= '<li>' . $album->render() . '</li>';
         }
         $html .= '</ul>';
         $html .= '<h3>Musiques</h3>';
         $html .= '<ul>';
         foreach ($this->musiques as $musique)
         {
               $html .= '<li>' . $musique->render() . '</li>';
         }
         $html .= '</ul>';
         $html .= '</div>';
   
         return $html;
     }
}