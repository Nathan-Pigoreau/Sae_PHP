<?php

declare(strict_types=1);

namespace Templates;

use Modele\ModeleDB\GenreDB;
use Modele\ModeleDB\PlaylistDB;
use Modele\ModeleDB\AlbumDB;
require_once '../Classes/autoloader.php'; 

$__GENRE__ = new GenreDB();
$__PLAYLIST__ = new PlaylistDB();
$__ALBUM__ = new AlbumDB();
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Gaitunes</title>
  <link rel="stylesheet" href="../Static/css/home.css">
</head>
<body>
<?php include 'base.php'; ?>

  <?php echo $genres = $__GENRE__->displayGenres();?>
  <!-- <?php echo $playlist = $__PLAYLIST__->displayPlaylist();?> -->
  <?php echo $album = $__ALBUM__->displayAlbum();?>
</body>