<?php

declare(strict_types=1);

namespace Modele\ModeleDB;

use PDO;
use Modele\Image;
Use Modele\DataBase;

final class ImageDB
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DataBase::getInstance();
    }

    public function getImage(int $idImage)
    {
        $query = "SELECT image FROM IMAGE WHERE idImage = :idImage";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idImage', $idImage);
        $stmt->execute();
        $imageData = $stmt->fetch(PDO::FETCH_ASSOC);
        $image = new Image($imageData['idImage'], $imageData['image']);
        return $image;
    }

}