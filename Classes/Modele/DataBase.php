<?php

declare(strict_types=1);

namespace Modele;

use PDO;

require_once(__DIR__ . '/../../Configuration/config.php');

class Database
{
    private static $instance = null;
    private $pdo;


    // Constructeur privé pour empêcher l'instanciation directe
    private function __construct()
    {
        try {
            $this->pdo = new PDO("sqlite:" . SQLITE_DB);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    // Méthode pour obtenir l'instance de la base de données (singleton)
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance->pdo;
    }
}