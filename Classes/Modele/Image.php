<?php

declare(strict_types=1);

namespace Modele;

final class Image{
    private int $idImage;

    private String $image; // Chemin de l'image

    // Constructeur

    public function __construct(int $idImage, String $image)
    {
        $this->idImage = $idImage;
        $this->image = $image;
    }

    // Getters

    public function getIdImage(): int
    {
        return $this->idImage;
    }

    public function getImage(): String
    {
        return $this->image;
    }

    // Setters

    public function setImage(String $image): void
    {
        $this->image = $image;
    }



}