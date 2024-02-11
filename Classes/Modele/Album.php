<?php

declare(strict_types=1);

namespace Modele;

use Modele\ModeleDB\AlbumDB;

final class Album
{
    private int $idAlbum;

    private int $idArtiste;

    private String $nomAlbum;

    private date $realeaseYear;

    private String $image;

    /**
     * @var Genre[]
     */
    private array $genres = [];

    private AlbumDB $modelDB;

    public function __construct(int $idAlbum, int $idArtiste, String $nomAlbum, date $realseYear, Image $image)
    {
        $this->idAlbum = $idAlbum;
        $this->idArtiste = $idArtiste;
        $this->nomAlbum = $nomAlbum;
        $this->realeaseYear = $realeaseYear;
        $this->genres = [];
        $this ->image = $image;
        $this->musiques = [];

        $this->modelDB = new AlbumDB();
    }

    public function getIdAlbum(): int
    {
        return $this->idAlbum;
    }

    public function getIdArtiste(): int
    {
        return $this->idArtiste;
    }

    public function getNomAlbum(): String
    {
        return $this->nomAlbum;
    }

    public function getRealeaseYear(): date
    {
        return $this->realeaseYear;
    }

    public function getIdGenre(): int
    {
        return $this->idGenre;
    }

    public function getImage(): String
    {
        return $this->image;
    }

    public function getMusiques(): Array
    {
        return $this->musiques;
    }

    public function setImage(String $image): void
    {
        $this->image = $image;
        $this->updateAlbum();
    }

    public function setNomAlbum(String $nomAlbum): void
    {
        $this->nomAlbum = $nomAlbum;
        $this->updateAlbum();
    }

    public function setRealeaseYear(date $realeaseYear): void
    {
        $this->realeaseYear = $realeaseYear;
        $this->updateAlbum();
    }


    public function addMusique(Musique $musique): void
    {
        $this->musiques[] = $musique;
        if($musique->getAlbum() !== null)
        {
            $musique->getAlbum()->removeMusique($musique);
        }
        $this->modelDB->addMusiqueAlbum($this->idAlbum, $musique->getIdMusique());
    }

    public function removeMusique(Musique $musique): void
    {
        $idMusique = $musique->getIdMusique();
        $index = array_search($idMusique, array_column($this->musiques, 'idMusique'));

        if ($index !== false) {
            unset($this->musiques[$index]);
            $this->musiques = array_values($this->musiques);
        }

        $musique->setAlbum(null);
        $this->modelDB->removeMusiqueAlbum($this->idAlbum, $idMusique);
    }

    public function updateAlbum(): void
    {
        $this->modelDB->updateAlbum($this);
    }

    public function render()
    {
        $html = '<div class="album">';
        $html .= '<div class="album-image">';
        $html .= '<img src="' . $this->image . '" alt="' . $this->nomAlbum . '">';
        $html .= '</div>';
        $html .= '<div class="album-infos">';
        $html .= '<h2>' . $this->nomAlbum . '</h2>';
        $html .= '<h3>' . $this->realeaseYear . '</h3>';
        $html .= '<h3>' . $this->genre . '</h3>';
        $html .= '<h3>' . $this->artiste . '</h3>';
        $html .= '</div>';
        $html .= '<div class="album-musiques">';
        foreach ($this->musiques as $musique)
        {
            $html .= $musique->render();
        }
        $html .= '</div>';
        return $html;
    }
}