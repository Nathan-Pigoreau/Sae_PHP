<?php
declare(strict_types=1);

namespace Templates;

use Modele\ModeleDB\AlbumDB;
use Modele\ModeleDB\MusiqueDB;
$__ALBUM__ = new AlbumDB();
$__MUSIQUE__ = new MusiqueDB();
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
                    $albums = array_slice($albums, 0, 6);
                    foreach ($albums as $album) {
                        echo $album->render();
                    }
                ?>
                <a href="albums"> Voir tous les albums</a> 
            </div>
            <h2>Musiques</h2>
            <div class="musiques">
                <?php
                    $musiques = $__MUSIQUE__->getMusiques();
                    $musiques = array_slice($musiques, 0, 6);
                    foreach ($musiques as $musique) {
                        echo $musique->renderaccueil();
                    }
                ?>
                <a class = 'toutmusique' href="musiques"> Voir toutes les musiques</a>
        </section>
    </main>
</body>
</html>