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

    private int $releaseYear;

    
    private String $image;

     /**
     * @var Genre[]
     */
    private array $genres = [];

    private int $nbVues;

    
    // Constructeur

    public function __construct(int $idMusique, int $idArtiste, String $nomMusique, int $releaseYear, String $image, int $nbVues)
    {
        $this->idMusique = $idMusique;
        $this->idAlbum = null;
        $this->idArtiste = $idArtiste;
        $this->nomMusique = $nomMusique;
        $this->releaseYear = $releaseYear;
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

    public function getReleaseYear(): int
    {
        return $this->releaseYear;
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

    public function setImage(String $image): void
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
        $modelDB = new MusiqueDB();
        $modelDB->updateMusique($this);
    }

    public function toArray(): array
    {
        return [
            "idMusique" => $this->idMusique,
            "idAlbum" => $this->idAlbum,
            "idArtiste" => $this->idArtiste,
            "nomMusique" => $this->nomMusique,
            "releaseYear" => $this->releaseYear,
            "image" => $this->image,
            "nbVues" => $this->nbVues
        ];
    }

    public function render(): string
    {
        $html = "<div class='musique'>";
        $html .= '<img src="'. '/Static/images/'. $this->image . '" alt="' . $this->nomMusique . '">';
        $html .= "<h2><a href='musique-details?id=" . $this->idMusique . "'>". $this->nomMusique . "</a></h2>";
        $html .= "<p>" . $this->releaseYear . "</p>";
        $html .= "<p>" . $this->nbVues . "</p>";
        $html .= "</div>";

        return $html;
    }
    public function renderaccueil(): string{
        $html = "<div class='musique'>";
        $html .= '<img class = "imgmusique" src="'. '/Static/images/'. $this->image . '" alt="' . $this->nomMusique . '">';
        $html .= "<div class='musique-details'>";
        $html .= "<h2><a href='musique-details?id=" . $this->idMusique . "'>". $this->nomMusique . "</a></h2>";
        // $html .= "<p>" . $this->releaseYear . "</p>";
        $html .= "</div>";
        $html .= "</div>";
        return $html;

    }

    public function renderDetails(): string
    {
        $modelDB = new MusiqueDB();

        if(isset($_SESSION['user']) && $modelDB->isFavoris($_SESSION['user']->getIdUser(), $this->idMusique)){
            $like = "Logo_like.png";
        }
        else{
            $like = "Logo_like_2.png";
        }

        $html = "<div class='musique-details'>";
        $html .= $this->render();
        $html .= "<h2>" . $modelDB->getNomArtiste($this->idArtiste) . "</h2>";
        foreach ($this->genres as $genre) {
            $html .= $genre->render() . " ";
        }
        $html .= "<button class='like-button' data-id='" . $this->idMusique . "'><img class='like' src='/Static/images/" . $like . "' alt='bouton_like'></button>";
        if($this->idAlbum)
        {
            $album = $modelDB->getMusiqueAlbum($this->idAlbum);
            $html .= $album->render();
        }
        $html .= "</div>";

        return $html;
    }

    public function renderPlaylist(int $idPlaylist): string
    {
        $html = "<div class='musique'>";
        $html .= "<h2>" . $this->nomMusique . "</h2>";
        $html .= "<form action='/Classes/Controller/controllerRemoveMusiquePlaylist.php' method='post'>";
        $html .= "<input type='hidden' name='idMusique' value='" . $this->idMusique . "'>";
        $html .= "<input type='hidden' name='idPlaylist' value='" . $idPlaylist . "'>";
        $html .= "<button type='submit'>Supprimer</button>";
        $html .= "</div>";
        
        return $html;
    }

   
    public function renderAdmin(): string
    {
        $html = "<div class='musique'>";
        $html .= "<img src='path/to/musique/images/{$this->image}' alt='{$this->nomMusique}'>";
        $html .= "<h2>{$this->nomMusique}</h2>";
        $html .= "<p>Date de sortie: {$this->releaseYear}</p>";
        $html .= "<p>Nombre de vues: {$this->nbVues}</p>";
        $html .= "<button onclick='confirmDelete({$this->idMusique})'>Supprimer</button>";
        $html .= '<script>
            function confirmDelete(artisteId) {
                var confirmDelete = confirm("Voulez-vous vraiment supprimer cet artiste?");
                if (confirmDelete) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "/Classes/Controller/controllerDeleteArtiste.php");
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            console.log("Artiste supprimé avec succès.");
                            window.location.reload();
                            alert("Artiste supprimé avec succès.");
                        } else {
                            console.error("Erreur lors de la suppression de l\'artiste.");
                        }
                    };
                    xhr.send("id=" + artisteId);
                }
            }
        </script>';
        $html .= "</div>";

        return $html;
    }
}