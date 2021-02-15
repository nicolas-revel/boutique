<?php

require_once('../vendor/autoload.php');

session_start();

$contconnexion = new \app\controllers\Controllerconnexion();

if (isset($_POST['loguser'])) {
  try {
    $_SESSION['user'] = $contconnexion->connectUser($_POST['email'], $_POST['password']);
    header('Location:../index.php');
  } catch (\Exception $e) {
    $error_msg = $e->getMessage();
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
</head>

<body>
  <main>
    <h1>Connexion</h1>
    <form action="connexion.php" method="post">
      <div class="form-item">
        <label for="email">Votre mail :</label>
        <input type="email" name="email" id="email" placeholder="Votre mail ici" required spellcheck="true">
      </div>
      <div class="form-item">
        <label for="password">Votre mot de passe :</label>
        <input type="password" name="password" id="password" placeholder="Votre mot de passe ici" required>
      </div>
      <input type="submit" name="loguser" value="Me connecter !">
    </form>
    <?php if (isset($error_msg)) : echo $error_msg;
    endif; ?>
  </main>
</body>

</html>