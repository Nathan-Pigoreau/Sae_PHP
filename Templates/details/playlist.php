<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher Playlist</title>
    <link rel="stylesheet" href="/Static/css/playlist.css">
</head>
<body>
    <h1>Playlist</h1>
    <?php
        session_start();

        if (isset($_POST['playList'])) {
            $playlist = $_POST['playList'];

            // Assurez-vous que la classe Playlist a une méthode render()
            // Utilisez la méthode render() pour afficher la playlist
            echo $playlist->render();
        } else {
            echo "Erreur : Aucune playlist trouvée.";
        }
    ?>
</body>
</html>
