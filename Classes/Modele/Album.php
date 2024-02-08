<?php

declare(strict_types=1);

namespace Modele;

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

    public function __construct(int $idAlbum, int $idArtiste, String $nomAlbum, date $realseYear, Image $image)
    {
        $this->idAlbum = $idAlbum;
        $this->idArtiste = $idArtiste;
        $this->nomAlbum = $nomAlbum;
        $this->realeaseYear = $realeaseYear;
        $this->genres = [];
        $this ->image = $image;
        $this->musiques = [];
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
    }

    public function setMusiques(Array $musiques): void
    {
        $this->musiques = $musiques;
    }

    public function addMusique(Musique $musique): void
    {
        $this->musiques[] = $musique;
    }

    public function removeMusique(Musique $musique): void
    {
        $key = array_search($musique, $this->musiques, true);
        if ($key !== false) {
            unset($this->musiques[$key]);
        }
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
        $html .= '</div>';
        return $html;
    }
}