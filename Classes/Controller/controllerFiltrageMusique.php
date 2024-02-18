<?php
declare(strict_types=1);
namespace Controller;
require_once '../autoloader.php';
use Modele\ModeleDB\MusiqueDB;

$__MUSIQUE__ = new MusiqueDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedGenre = (int)$_POST["selectedGenre"];
    $selectedYear = (int)($_POST["selectedYear"]);

    if ($selectedGenre == "0" && $selectedYear == null) {
        $musiques = $__MUSIQUE__->getMusiques();
    }
    elseif ($selectedGenre == "0") {
        $musiques = $__MUSIQUE__->filtreMusiqueYear($selectedYear);
    }
    elseif ($selectedYear == null) {
        $musiques = $__MUSIQUE__->filtreMusiqueGenre($selectedGenre);
    } else {
        $musiques = $__MUSIQUE__->filtreMusique($selectedGenre, $selectedYear);
    }

    $reponse = [];
    foreach ($musiques as $musique) {
        array_push($reponse, $musique->toArray());
    }


    echo json_encode($reponse);
}