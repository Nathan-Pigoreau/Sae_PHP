<?php 

declare(strict_types=1);

namespace Modele;

final class Playlist
{
    private int $idPlaylist;

    private String $nomPlaylist;

    private int $idUser;

    /**
     * @var Musique[]
     */
    private array $musiques = [];

    private PlaylistDB $modelBD;


    // Constructeur

    public function __construct(int $idPlaylist, String $nomPlaylist, int $idUser)
    {
        $this->idPlaylist = $idPlaylist;
        $this->nomPlaylist = $nomPlaylist;
        $this->idUser = $idUser;
        $this->musiques = [];

        $this->modelBD = new PlaylistDB();
    }

    // Getters

    public function getIdPlaylist(): int
    {
        return $this->idPlaylist;
    }

    public function getNomPlaylist(): String
    {
        return $this->nomPlaylist;
    }

    public function getIdUser(): int
    {
        return $this->idUser;
    }

    public function getMusiques(): array
    {
        return $this->musiques;
    }

    // Setters


    public function setNomPlaylist(String $nomPlaylist): void
    {
        $this->nomPlaylist = $nomPlaylist;
        $this->updatePlaylist();
    }

    public function addMusique(Musique $musique): void
    {
        $this->musiques[] = $musique;
        $this->modelBD->addMusique($this->idPlaylist, $musique->getIdMusique());
    }

    public function removeMusique(Musique $musique): void
    {
        $key = array_search($musique, $this->musiques);
        if ($key !== false) {
            unset($this->musiques[$key]);
            $this->modelBD->removeMusique($this->idPlaylist, $musique->getIdMusique());
        }
    }

    public function updatePlaylist(): void
    {
        $this->modelBD->updatePlaylist($this);
    }


    public function render(): string
    {
        $html = "<div class='playlist'>";
        $html .= "<h2>" . $this->nomPlaylist . "</h2>";
        $html .= "<div class='musiques'>";
        foreach ($this->musiques as $musique)
        {
            $html .= $musique->render();
        }
        $html .= "</div>";
        $html .= "</div>";

        return $html;
    }

}


