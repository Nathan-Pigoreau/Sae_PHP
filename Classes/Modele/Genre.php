<?php

declare(strict_types=1);

namespace Genre\Type;

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
}