<?php

declare(strict_types=1);

namespace Modele;

final class Musique
{
    private int $idMusique;

    private ?int $idAlbum;

    private int $idArtiste;

    private String $nomMusique;

    private date $realeaseYear;

    
    private String $image;

     /**
     * @var Genre[]
     */
    private array $genres = [];

    private int $nbVues;

    
    // Constructeur

    public function __construct(int $idMusique, int $idArtiste, String $nomMusique, date $realeaseYear,Image $image, int $nbVues)
    {
        $this->idMusique = $idMusique;
        $this->idAlbum = null;
        $this->idArtiste = $idArtiste;
        $this->nomMusique = $nomMusique;
        $this->realeaseYear = $realeaseYear;
        $this->image = $image;
        $this->genres = [];
        $this->nbVues = $nbVues;
    }

    // Getters

    public function getIdMusique(): int
    {
        return $this->idMusique;
    }

    public function getIdAlbum(): int
    {
        return $this->idAlbum;
    }

    public function getNomMusique(): String
    {
        return $this->nomMusique;
    }

    public function getRealeaseYear(): date
    {
        return $this->realeaseYear;
    }

    public function getGenres(): array
    {
        return $this->genres;
    }

    public function getNbVues(): int
    {
        return $this->nbVues;
    }

    // Setters

    public function setNomMusique(String $nomMusique): void
    {
        $this->nomMusique = $nomMusique;
    }

    public function setImage(Image $image): void
    {
        $this->image = $image;
    }

    public function addGenre(Genre $genre): void
    {
        $this->genres[] = $genre;
    }

    public function removeGenre(Genre $genre): void
    {
        $this->genres = array_filter($this->genres, function (Genre $g) use ($genre) {
            return $g->getIdGenre() !== $genre->getIdGenre();
        });
    }

    public function setIdAlbum(int $idAlbum): void
    {
        $this->idAlbum = $idAlbum;
    }

    public function gender(): string
    {
        $html = "<div class='musique'>";
        $html .= "<img src='" . $this->image . "' alt='image musique'>";
        $html .= "<h2>" . $this->nomMusique . "</h2>";
        $html .= "<p>" . $this->realeaseYear . "</p>";
        $html .= "<p>" . $this->nbVues . "</p>";
        $html .= "</div>";

        return $html;
    }
}