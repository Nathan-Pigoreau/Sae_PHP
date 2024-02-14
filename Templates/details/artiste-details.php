<?php

namespace Templates\details;

use Modele\ModeleDB\ArtisteDB;

$__ARTISTE__ = new ArtisteDB();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if($__ARTISTE__->isExist($id))
    {
        $artiste = $__ARTISTE__->getArtiste($id);
    }
    else{header('Location: /');}
} else { header('Location: /');}

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
        <h1>Artiste</h1>
        <section>
            <?php echo $artiste->renderDetails(); ?>
        </section>
</body>
</html>