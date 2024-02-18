<?php
declare(strict_types=1);

namespace Templates;
 
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Gaitunes</title>
  <link rel="stylesheet" href="../Static/css/login.css">
</head>
<body>
<div class="login wrap">
  <h1>LOGIN</h1>
  <div class="h1"></div>
    <form action="../Classes/Controller/controllerLogin.php" method="POST">
      <input placeholder="Email" id="email" name="email" type="email">
      <input placeholder="Password" id="password" name="password" type="password">
      <input value="Login" class="btn" type="submit">
    </form>
  <p>Pas encore inscrit ?<a href="register"> Inscrivez-vous </a></p>
  <?php
      if (isset($_GET['error']) && $_GET['error'] === "1") {
          echo "<p>Identifiants incorrect</p>";
      }
    ?>
</div>
</div>
</body>
</html>
