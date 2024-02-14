<?php
declare(strict_types=1);

namespace Templates;

use Modele\ModeleDB\AlbumDB;

$__ALBUM__ = new AlbumDB();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Static/css/main.css">
    <title>Gaitunes</title>
</head>
<body>
    <?php include 'base.php'; ?>
    <main>
        <!-- <h1>Accueil</h1> -->
        <p>Bienvenue sur Gaitunes, le site de streaming musical qui vous permet de créer et d'écouter vos playlists en ligne.</p>
        <p>Connectez-vous pour accéder à votre espace personnel.</p>

        <section>
            <h2>Albums</h2>
            <div class="albums">
                <?php
                    $albums = $__ALBUM__->getAlbums();
                    $albums = array_slice($albums, 0, 5);
                    foreach ($albums as $album) {
                        echo $album->render();
                    }
                ?>
            </div>
    </main>
</body>
</html>