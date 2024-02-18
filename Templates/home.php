<?php

declare(strict_types=1);

namespace Templates;

use Modele\ModeleDB\GenreDB;

require_once '../Classes/autoloader.php'; 

$__GENRE__ = new GenreDB();


?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Gaitunes</title>
  <link rel="stylesheet" href="../Static/css/home.css">
</head>
<body>
  <?php echo $genres = $__GENRE__->displayGenres();?>
</body>