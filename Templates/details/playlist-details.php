<?php

declare(strict_types=1);

namespace Templates\details;

use Modele\ModeleDB\PlaylistDB;

$playlistDB = new PlaylistDB();
$playlist = $playlistDB->getPlaylist((int)$_GET['id']);

?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Gaitunes</title>
  <link rel="stylesheet" href="../../Static/css/main.css">
</head>
<body>
    <?php include __DIR__ . '/../base.php'; ?>
    <main>
        <h1>Playlist</h1>
        <section>
            <?php echo $playlist->render(); ?>
        </section>
</body>
</html>
