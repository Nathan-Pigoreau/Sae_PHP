<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Static/css/playlist.css">

    <title>Ajouter Playlist</title>
</head>
<body>
    <h1>Ajouter Playlist</h1>
    <form action="../Classes/Controller/ControllerPlaylist.php" method="post">
        <label for="nom_playlist">Nom de la playlist :</label>
        <input type="text" id="nom_playlist" name="nom_playlist" required>
        <button type="submit">Ajouter Playlist</button>
    </form>
</body>
</html>