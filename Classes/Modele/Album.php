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
        $this ->image = $image;

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

    public function getReleaseYear(): int
    {
        return $this->releaseYear;
    }

    public function getIdGenre(): int
    {
        return $this->idGenre;
    }

    public function getGenres(): Array
    {
        return $this->genres;
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

    public function setReleaseYear(int $releaseYear): void
    {
        $this->releaseYear = $releaseYear;
        $this->updateAlbum();
    }

    public function setIdArtiste(int $idArtiste): void
    {
        $this->idArtiste = $idArtiste;
        $this->updateAlbum();
    }

    public function setImageAlbum(string $image): void
    {
        $this->image = $image;
        $this->updateAlbum();
    }

    public function resetGenre(): void
    {
        $this->genres = [];
    }

    public function initGenre(Genre $genre): void
    {
        $this->genres[] = $genre;
    }

    public function initMusique(Musique $musique): void
    {
        $this->musiques[] = $musique;
    }

    public function addGenre(Genre $genre): void
{
    $this->genres[] = $genre;
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
        $html .= '<img src="'. __DIR__ ."../../Static/images". $this->image . '" alt="' . $this->nomAlbum . '">';
        $html .= '</div>';
        $html .= '<div class="album-infos">';
        $html .= '<h2>' . $this->nomAlbum . '</h2>';
        $html .= '<h3>' . $this->releaseYear . '</h3>';
        $html .= '<h3>' . $this->idArtiste . '</h3>';
        $html .= '</div>';
        $html .= '<div class="album-musiques">';
        foreach ($this->musiques as $musique)
        {
            $html .= $musique->render();
        }
        foreach ($this->genres as $genre)
        {
            $html .= $genre->render();
        }
        $html .= '</div>';
        return $html;
    }

    public function renderAdmin(){
        $html = '<div class="album">';
        $html .= '<h2>' . $this->nomAlbum . '</h2>';
        $html .= '<p>Date de sortie : ' . $this->releaseYear . '</p>';
        $html .= '<p>Artiste : ' . $this->idArtiste . '</p>';
        
        $html .= '<a href="/admin/albums/modifier?id=' . $this->idAlbum . '"><button>Modifier</button></a>';
        
        // Utilisez une fonction JavaScript pour confirmer la suppression avec une requête AJAX
        $html .= '<button onclick="confirmDelete(' . $this->idAlbum . ')">Supprimer</button>';
        
        $html .= '</div>';
    
        // Ajoutez le script JavaScript une seule fois à la fin de votre document
        $html .= '<script>
                    function confirmDelete(albumId) {
                        var confirmDelete = confirm("Voulez-vous vraiment supprimer cet album?");
                        if (confirmDelete) {
                            
                            var xhr = new XMLHttpRequest();
                            xhr.open("POST", "/Classes/Controller/controllerDeleteAlbum.php");
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhr.onload = function() {
                                if (xhr.status === 200) {
                                    console.log("Album supprimé avec succès.");
                                    window.location.reload();
                                    alert("Album supprimé avec succès.");
                                } else {
                                    console.error("Erreur lors de la suppression de l\' album.");
                                }
                            };
                            xhr.send("id=" + albumId);
                        }
                    }
                  </script>';
    
        return $html;
    }
    
}