<?php 

declare(strict_types=1);

namespace Templates;

use Modele\ModeleDB\MusiqueDB;

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
    <h1>Musiques</h1>
    <div class="musiques">
        <?php
            $musiques = $__MUSIQUE__->getMusiques();
            foreach ($musiques as $musique) {
                echo $musique->renderaccueil();
            }
        ?>
    </div>
</main>
</body>
</html>



