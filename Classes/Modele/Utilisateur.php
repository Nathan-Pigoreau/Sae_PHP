<?php

declare(strict_types=1);

namespace Modele;

use Modele\ModeleDB\UtilisateurDB;

final class Utilisateur
{
    private int $idUser;

    private String $pseudo;

    private String $mdp;

    private String $email;

    private String $descriptionUser;

    private String $roleU;

    /**
     * @var Musique[]
     */
    private array $favoris = [];
    /**
     * @var Playlist[]
     */
    private array $playlists = [];

    
    private String $pdp;

    private UtilisateurDB $modelDB;
    // Constructeur

    public function __construct(int $idUser, String $pseudo, String $mdp, String $email, String $descriptionUser, String $roleU)
    {
        $this->idUser = $idUser;
        $this->pseudo = $pseudo;
        $this->mdp = $mdp;
        $this->email = $email;
        $this->descriptionUser = $descriptionUser;
        $this->roleU = $roleU;
        $this->pdp = "defaultPDP.png";
        $this->favoris = [];
        $this->playlists = [];

        $this->modelDB = new UtilisateurDB();
    }

    // Getters

    public function getIdUser(): int
    {
        return $this->idUser;
    }

    public function getPseudo(): String
    {
        return $this->pseudo;
    }

    public function getMdp(): String
    {
        return $this->mdp;
    }

    public function getEmail(): String
    {
        return $this->email;
    }

    public function getDescriptionUser(): String
    {
        return $this->descriptionUser;
    }

    public function getRoleU(): String
    {
        return $this->roleU;
    }

    public function getPdp(): Image
    {
        return $this->pdp;
    }

    public function getFavoris(): array
    {
        return $this->favoris;
    }

    public function getPlaylists(): array
    {
        return $this->playlists;
    }

    // Setters

    public function setPseudo(String $pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    public function setMdp(String $mdp): void
    {
        $this->mdp = $mdp;
    }

    public function setEmail(String $email): void
    {
        $this->email = $email;
    }

    public function setDescriptionUser(String $descriptionUser): void
    {
        $this->descriptionUser = $descriptionUser;
    }

    public function setRoleU(String $roleU): void
    {
        $this->roleU = $roleU;
    }

    public function setPdp(String $pdp): void
    {
        $this->pdp = $pdp;
    }

    public function addFavoris(int $idmusique): void
    {
        $this->modelDB->addFavoris($this->idUser, $idmusique);
        $this->favoris = $this->modelDB->getMusique($idmusique);
    }

    public function removeFavoris(int $idmusique): void
    {
        $this->modelDB->removeFavoris($this->idUser, $idmusique);
        $key = array_search($idmusique, array_column($this->favoris, 'idMusique'));
        if ($key !== false) {
            unset($this->favoris[$key]); // Supprime la musique de la liste des favoris
        }
    }

    public function addPlaylist(Playlist $playlist): void
    {
        $this->playlists[] = $playlist; // Ajoute la playlist à la liste des playlists
    }

    public function removePlaylist(Playlist $playlist): void
    {
        $key = array_search($playlist, $this->playlists, true); // Cherche la playlist dans la liste des playlists
        if ($key !== false) {
            unset($this->playlists[$key]); // Supprime la playlist de la liste des playlists
        }
    }


    public function render(): string
    {
        $html = "<div class='utilisateur'>";
        $html .= "<h2>" . $this->pseudo . "</h2>";
        $html .= "<p>" . $this->descriptionUser . "</p>";
        $html .= "<div class='favoris'>";
        foreach ($this->favoris as $musique)
        {
            $html .= $musique->render();
        }
        $html .= "</div>";
        $html .= "</div>";

        return $html;
    }


    public function renderUserPlaylist(): string
    {
        $html = "<div class='playlists'>";
        foreach ($this->playlists as $playlist)
        {
            $html .= $playlist->render();
        }
    }




}