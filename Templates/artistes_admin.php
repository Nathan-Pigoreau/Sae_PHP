<?php

declare(strict_types=1);

namespace Templates;

require_once __DIR__ . '/../Classes/autoloader.php';

use Modele\ModeleDB\ArtisteDB;

$__ARTISTE__ = new ArtisteDB();


?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Gaitunes</title>
  <link rel="stylesheet" href="../Static/css/albums_admin.css">
</head>
<body>
  <h1>Artistes</h1>
  <div class="container">
    <?php echo $artistes = $__ARTISTE__->displayArtistesAdmin();?>
  </div>
</body>