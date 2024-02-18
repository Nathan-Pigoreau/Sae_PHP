<?php 
    if (session_status() == PHP_SESSION_NONE){
        session_start();
    }

    if (!isset($_SESSION['user'])) {
        header("Location: /login");
        exit();
    }

    $user = $_SESSION['user'];
    $favoris = $user->getFavoris();


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/Static/css/main.css">
    <title>Gaitunes</title>
</head>
<body>
    <?php include __DIR__ . '/base.php'; ?>
    <main>
        <h1>Favoris</h1>
        <?php foreach ($favoris as $favori): ?>
            <?php echo $favori->renderaccueil(); ?>
        <?php endforeach;
        ?>
    </main>
</body>
</html>
