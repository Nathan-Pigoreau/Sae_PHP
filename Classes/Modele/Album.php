<?php

declare(strict_types=1);

namespace Modele;

use Modele\ModeleDB\AlbumDB;

final class Album
{
    private int $idAlbum;

    private int $idArtiste;

    private String $nomAlbum;

    private int $releaseYear;

    private String $image;

    /**
     * @var Genre[]
     */
    private array $genres = [];

    /**
     * @var Musique[]
     */
    private array $musiques = [];

    private AlbumDB $modelDB;

    public function __construct(int $idAlbum, int $idArtiste, String $nomAlbum, int $releaseYear, String $image)
    {
        $this->idAlbum = $idAlbum;
        $this->idArtiste = $idArtiste;
        $this->nomAlbum = $nomAlbum;
        $this->releaseYear = $releaseYear;
        if($image === null || $image == "null"){$this->image = "default.jpg";}
        else{$this->image = $image;}

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

    public function getRealeaseYear(): int
    {
        return $this->releaseYear;
    }

    public function getImage(): String
    {
        return $this->image;
    }

    public function getMusiques(): Array
    {
        return $this->musiques;
    }

    public function getGenres(): Array
    {
        return $this->genres;
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

    public function setRealeaseYear(int $realeaseYear): void
    {
        $this->releaseYear = $releaseYear;
        $this->updateAlbum();
    }

    public function initGenre(Genre $genre): void
    {
        $this->genres[] = $genre;
    }

    public function initMusique(Musique $musique): void
    {
        $this->musiques[] = $musique;
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
        $html .= '<img class="imgalbum" src="'. '/Static/images/'. $this->image .'"' . '" alt="' . $this->nomAlbum . '">';
        $html .= '</div>';
        $html .= '<div class="album-infos">';
        $html .= '<h2><a href="/album-details?id=' . $this->idAlbum . '">'. $this->nomAlbum . '</a></h2>';
        $html .= '</div>';
        $html .= '<div class="album-musiques">';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

    public function getGenresRender(): String
    {
        $html = '<div class="album-genres">';
        foreach ($this->genres as $genre)
        {
            $html .= $genre->render();
        }
        $html .= '</div>';
        return $html;
    }

    public function getMusiquesRender(): String
    {
        $html = '<div class="album-musiques">';
        foreach ($this->musiques as $musique)
        {
            $html .= $musique->render();
        }
        $html .= '</div>';
        return $html;
    }

    public function renderDetails(): String
    {
        $html = '<div class="album-details">';
        $html .= '<div class="album-details-infos">';
        $html .= '<h2>' . $this->nomAlbum . '</h2>';
        $html .= '<h3>' . $this->releaseYear . '</h3>';
        $html .= '</div>';
        $html .= '<div class="album-details-image">';
        $html .= '<img src="'. '/Static/images/'. $this->image .'"' . '" alt="' . $this->nomAlbum . '">';
        $html .= '</div>';
        $html .= '<div class="album-details-musiques">';
        $html .= $this->getMusiquesRender();
        $html .= '</div>';
        $html .= $this->getGenresRender();
        $html .= '</div>';
        return $html;
    }
}