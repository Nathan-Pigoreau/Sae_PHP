<?php

declare(strict_types=1);

namespace Modele;

use Modele\ModeleDB\MusiqueDB;

final class Musique
{
    private int $idMusique;

    private ?int $idAlbum;

    private int $idArtiste;

    private String $nomMusique;

    private int $realeaseYear;

    
    private String $image;

     /**
     * @var Genre[]
     */
    private array $genres = [];

    private int $nbVues;

    private MusiqueDB $modelDB;

    
    // Constructeur

    public function __construct(int $idMusique, int $idArtiste, String $nomMusique, int $realeaseYear,String $image, int $nbVues)
    {
        $this->idMusique = $idMusique;
        $this->idAlbum = null;
        $this->idArtiste = $idArtiste;
        $this->nomMusique = $nomMusique;
        $this->realeaseYear = $realeaseYear;
        $this->image = $image;
        $this->genres = [];
        $this->nbVues = $nbVues;

        $this->modelDB = new MusiqueDB();
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

    public function updateMusique(): void
    {
        $this->modelDB->updateMusique($this);
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

   
    public function renderAdmin(): string
    {
        $html = "<div class='musique'>";
        $html .= "<img src='path/to/musique/images/{$this->image}' alt='{$this->nomMusique}'>";
        $html .= "<h2>{$this->nomMusique}</h2>";
        $html .= "<p>Date de sortie: {$this->realeaseYear}</p>";
        $html .= "<p>Nombre de vues: {$this->nbVues}</p>";
        $html .= "<button onclick='deleteMusique({$this->idMusique})'>Supprimer</button>";
        $html .= "</div>";

        return $html;
    }
}