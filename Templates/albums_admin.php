<?php

declare(strict_types=1);

namespace Templates;

require_once __DIR__ . '/../Classes/autoloader.php';

use Modele\ModeleDB\AlbumDB;

$__ALBUM__ = new AlbumDB();


?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Gaitunes</title>
  <link rel="stylesheet" href="../Static/css/albums_admin.css">
</head>
<body>
  <h1>Albums</h1>
  <div class="container">
    <?php echo $albums = $__ALBUM__->displayAlbumsAdmin();?>
  </div>
</body>