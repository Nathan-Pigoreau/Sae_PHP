<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Static/css/main.css">

    <title>Gaitunes</title>
</head>
<body>
    <?php include __DIR__ . '/base.php'; ?>
    <main>
        <h1>Ajouter Playlist</h1>
        <form action="../Classes/Controller/ControllerPlaylist.php" method="post">
            <label for="nom_playlist">Nom de la playlist :</label>
            <input type="text" id="nom_playlist" name="nom_playlist" required>
            <button type="submit">Ajouter Playlist</button>
        </form>

        <h1>Vos Playlists</h1>
        <?php 
            if (isset($_SESSION['user'])) {
                echo $_SESSION['user']->renderUserPlaylist();
            } else {
                echo "Vous n'avez pas de playlist";
            }
        ?>
    </main>
</body>
</html>