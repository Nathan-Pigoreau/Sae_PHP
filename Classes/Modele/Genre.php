<?php

declare(strict_types=1);

namespace Modele;

final class Genre{
    private int $idGenre;

    private String $nomGenre;

    // Constructeur

    public function __construct(int $idGenre, String $nomGenre)
    {
        $this->idGenre = $idGenre;
        $this->nomGenre = $nomGenre;
    }

    // Getters

    public function getIdGenre(): int
    {
        return $this->idGenre;
    }

    public function getNomGenre(): String
    {
        return $this->nomGenre;
    }

    // Setters

    public function setNomGenre(String $nomGenre): void
    {
        $this->nomGenre = $nomGenre;
    }


    public function render(): string
    {
        $html = "<div class='genre'>";
        $html .= "<h2>" . $this->nomGenre . "</h2>";
        $html .= "</div>";

        return $html;
    }
}