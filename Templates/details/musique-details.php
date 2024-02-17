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
        <h1>Musique</h1>
        <section>
            <?php echo $musique->renderDetails(); ?>
        </section>
</body>
<script>
    document.getElementsByClassName('like-button')[0].addEventListener('click', function() {
        var idMusique = this.getAttribute('data-id');
        fetch('/Classes/Controller/controllerLike.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'idMusique=' + idMusique,
        })
        .then(response => response.text())
        .then(data => {
            if (data === 'like') {
                this.innerHTML = '<img class="like" src="/Static/images/Logo_like.png" alt="bouton_like">';
            } else if (data === 'dislike'){
                this.innerHTML = '<img class="like" src="/Static/images/Logo_like_2.png" alt="bouton_dislike">';
            }
            else {
                alert('Vous devez être connecté pour aimer une musique');
            }

        })
        .catch((error) => {
            alert('Vous devez être connecté pour aimer une musique.');
            console.error('Error', error);
        });
    });
</script>
</html>