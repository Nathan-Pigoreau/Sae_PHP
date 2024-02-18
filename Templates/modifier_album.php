<?php

declare(strict_types=1);

namespace Templates;

use Modele\ModeleDB\AlbumDB;

require_once __DIR__ . '/../Classes/autoloader.php';

$albumDB = new AlbumDB();

// Supposons que vous récupérez l'ID de l'album à partir de la requête (à partir de l'URL)
$albumId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Récupérez les informations de l'album à partir de la base de données
$album = $albumDB->getAlbum($albumId);

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Modifier Album</title>
    <link rel="stylesheet" href="../Static/css/modifier.css">
    <script>
        function dragOverHandler(event) {
            event.preventDefault();
            // Ajoutez une classe pour mettre en surbrillance la zone de dépôt
            document.getElementById('dropArea').classList.add('highlight');
        }

        function dragLeaveHandler(event) {
            event.preventDefault();
            // Supprimez la classe de surbrillance de la zone de dépôt
            document.getElementById('dropArea').classList.remove('highlight');
        }

        function dropHandler(event) {
            event.preventDefault();
            // Supprimez la classe de surbrillance de la zone de dépôt
            document.getElementById('dropArea').classList.remove('highlight');

            // Récupérez le fichier déposé
            const file = event.dataTransfer.files[0];

            // Mettez à jour l'affichage du nom du fichier (optionnel)
            document.getElementById('fileList').textContent = `Fichier sélectionné : ${file.name}`;

            // Mettez à jour la valeur de l'input file avec le fichier déposé
            document.getElementById('newAlbumImage').files = event.dataTransfer.files;
        }

        function handleFileSelect(input) {
            // Mettez à jour l'affichage du nom du fichier (optionnel)
            document.getElementById('fileList').textContent = `Fichier sélectionné : ${input.files[0].name}`;
        }
    </script>
</head>
<body>

    <h1>Modifier Album</h1>

    <form method="post" action="../../Classes/Controller/controllerEditAlbum.php">
        <!-- Champ caché pour identifier l'album -->
        <input type="hidden" name="idAlbum" value="<?php echo $album->getIdAlbum(); ?>">
    
        <label for="nomAlbum">Nom de l'album:</label>
        <input type="text" id="nomAlbum" name="nomAlbum" value="<?php echo $album->getNomAlbum(); ?>">
    
        <label for="releaseYear">Date de sortie:</label>
        <input type="text" id="releaseYear" name="releaseYear" value="<?php echo $album->getReleaseYear(); ?>">
    
        <label for="idArtiste">ID de l'artiste:</label>
        <input type="text" id="idArtiste" name="idArtiste" value="<?php echo $album->getIdArtiste(); ?>">

        <label for="idGenre">ID du genre:</label>
        <select id="idGenre" name="idGenre[]" multiple>
            <?php
            $genres = $albumDB->getGenres();
            $albumGenres = $album->getGenres();
        
            foreach ($genres as $genre) {
                echo "<option value=\"{$genre->getIdGenre()}\">{$genre->getNomGenre()}</option>";
            }
            ?>
        </select>


        
        <input type="submit" value="Enregistrer les modifications">

        <label for="newAlbumImage">Glisser-déposer l'image ici ou cliquez pour sélectionner un fichier :</label>
        <div id="dropArea" class="drop-area" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);" ondragleave="dragLeaveHandler(event);">
            <input type="file" id="newAlbumImage" name="newAlbumImage" accept="image/*" onchange="handleFileSelect(this)">
            <p id="fileList"></p>
        </div>
    </form>
    

</body>
</html>
