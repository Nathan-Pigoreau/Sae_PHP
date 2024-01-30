<?php 
class UtilisateurDB
{
    private $db; // L'objet PDO sera stocké ici

    public function __construct()
    {
        // Chemin vers le fichier SQLite
        $dbPath = __DIR__ . SQLITE_DB;

        // Connexion à la base de données SQLite
        try {
            $this->db = new PDO("sqlite:$dbPath");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données: " . $e->getMessage());
        }
    }

    public function createUser($pseudo, $mdp, $email, $descriptionU, $roleU = 'USER')
    {
        $query = "INSERT INTO UTILISATEUR (pseudo, mdp, email, descriptionU, roleU) VALUES (?, ?, ?, ?, ?)";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $pseudo);
            $stmt->bindParam(2, $mdp);
            $stmt->bindParam(3, $email);
            $stmt->bindParam(4, $descriptionU);
            $stmt->bindParam(5, $roleU);

            return $stmt->execute();
        } catch (PDOException $e) {
            die("Erreur lors de la création de l'utilisateur: " . $e->getMessage());
        }
    }

    public function getUserById($id)
    {
        $query = "SELECT * FROM UTILISATEUR WHERE id = ?";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors de la récupération de l'utilisateur: " . $e->getMessage());
        }
    }

    public function getUserByPseudo($pseudo)
    {
        $query = "SELECT * FROM UTILISATEUR WHERE pseudo = ?";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $pseudo);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors de la récupération de l'utilisateur: " . $e->getMessage());
        }
    }

    public function isUsedEmail($email)
    {
        $query = "SELECT * FROM UTILISATEUR WHERE email = ?";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $email);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors de la récupération de l'utilisateur: " . $e->getMessage());
        }
    }
}
