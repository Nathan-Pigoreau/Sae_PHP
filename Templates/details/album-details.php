<?php

namespace Templates\details;

use Modele\ModeleDB\AlbumDB;

$__ALBUM__ = new AlbumDB();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if($__ALBUM__->isExist($id))
    {
        $album = $__ALBUM__->getAlbum($id);
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
        <h1>Album</h1>
        <section>
            <?php echo $album->renderDetails(); ?>
        </section>
</body>
</html>
