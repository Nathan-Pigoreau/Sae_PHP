<?php

declare(strict_types=1);

namespace Templates;

use Modele\ModeleDB\ArtisteDB;

require_once __DIR__ . '/../Classes/autoloader.php';

$artisteDB = new ArtisteDB();

// Supposons que vous récupérez l'ID de l'artiste à partir de la requête (à partir de l'URL)
$artisteId = isset($_GET['id']) ? intval($_GET['id']) : 0;
// Récupérez les informations de l'artiste à partir de la base de données
$artiste = $artisteDB->getArtiste((int)$artisteId);
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Modifier Artiste</title>
    <link rel="stylesheet" href="../Static/css/modifier.css">
</head>
<body>

    <h1>Modifier Artiste</h1>

    <form method="post" action="../../Classes/Controller/controllerEditArtiste.php">
        <!-- Champ caché pour identifier l'artiste -->
        <input type="hidden" name="idArtiste" value="<?php echo $artiste->getIdArtiste(); ?>">
    
        <label for="nomA">Nom de l'artiste:</label>
        <input type="text" id="nomA" name="nomA" value="<?php echo $artiste->getNomA(); ?>">
    
        <label for="prenomA">Prénom de l'artiste:</label>
        <input type="text" id="prenomA" name="prenomA" value="<?php echo $artiste->getPrenomA(); ?>">
    
        <label for="descriptionA">Description de l'artiste:</label>
        <textarea id="descriptionA" name="descriptionA"><?php echo $artiste->getDescriptionA(); ?></textarea>
        
        <input type="submit" value="Enregistrer les modifications">
    </form>
    

</body>
</html>