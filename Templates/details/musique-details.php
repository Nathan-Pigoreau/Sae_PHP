<?php

namespace Templates\details;

use Modele\ModeleDB\MusiqueDB;

$__MUSIQUE__ = new MusiqueDB();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if($__MUSIQUE__->isExist($id))
    {
        $musique = $__MUSIQUE__->getMusique($id);
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
            <?php echo $musique->renderDetails(); ?>
        </section>
</body>
</html>