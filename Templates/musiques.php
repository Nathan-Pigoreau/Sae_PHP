<?php 

declare(strict_types=1);

namespace Templates;

use Modele\ModeleDB\MusiqueDB;
use Modele\ModeleDB\GenreDB;

$__MUSIQUE__ = new MusiqueDB();
$__GENRE__ = new GenreDB();

$musiques = $__MUSIQUE__->getMusiques();
$genres = $__GENRE__->getGenres();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Static/css/main.css">
    <script src="/Script/filtrageMusique.js" defer></script>
    <title>Gaitunes</title>
</head>
<body>
<?php include 'base.php'; ?>

<main>
    <h1>Musiques</h1>
    <p>Filtrage : </p>
    <label for="genres">Par genres</label>
        <select id="genres" name="genres">
        <option value="0">Tout</option>
        <?php foreach ($genres as $genre): ?>
            <option value=<?php echo $genre->getIdGenre(); ?>> <?php echo $genre->getNomGenre(); ?></option>;
        <?php endforeach; ?>
        </select>
    <label for="annee">Par année</label>
        <input type="number" id="annee" name="annee" min="1900" max="2024">
    <div class="musiques" id="musiques">
        <?php
            foreach ($musiques as $musique) {
                echo $musique->renderaccueil();
            }
        ?>
    </div>
</main>
</body>
</html>



