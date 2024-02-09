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
  <h1>REGISTER</h1>
  <div class="h1"></div>
    <form action="../Classes/Controller/ControllerRegister.php" method="POST">
      <input placeholder="Pseudo" id="pseudo" name="pseudo" type="text">
      <input placeholder="Email" id="email" name="email" type="email">
      <input placeholder="Password" id="password" name="password" type="password">
      <input value="Register" class="btn" type="submit">
    </form>
    <?php
      if (isset($_GET['error']) && $_GET['error'] === "1") { // Si on a une erreur et que ce sont les identifiants incorrects
          echo "<p>Identifiants déjà utilisés</p>";
      }
    ?>
  </div>
</div>
</body>
</html>