<?php 

declare(strict_types=1);

namespace Artiste;

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
     }

     public function setPrenomA(String $prenomA): void
     {
        $this->prenomA = $prenomA;
     }

     public function setImage(String $image): void
     {
        $this->imageArtiste = $image;
     }

     public function descriptionA(String $descriptionA): void
     {
        $this->descriptionA = $descriptionA;
     }

     public function addNbAuditeurs(): void
     {
        $this->nbAuditeurs += 1;
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
        }
     }

     public function addMusiques(Musique $musique): void
     {
        $this->musiques[] = $musique;
     }

     public function removeMusique(int $idMusique): void
     {
        $index = array_search($idMusique, array_column($this->musiques, 'idMusique'));

        if ($index !== false) {
            unset($this->musiques[$index]);
            $this->musiques = array_values($this->musiques);
        }
     }
}