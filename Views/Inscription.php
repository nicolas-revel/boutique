<?php
require_once('../vendor/autoload.php');

session_start();

$continsc = new \app\controllers\Controllerinscription();

if (isset($_POST['register'])) {
  try {
    $tryinsert = $continsc->insertUser($_POST['email'], $_POST['password'], $_POST['c_password']);
  } catch (\Exception $e) {
    $errormsg = $e->getMessage();
  }
}

var_dump($_POST);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription</title>
</head>

<body>
  <main>
    <h1>Page d'inscription</h1>
    <form action="Inscription.php" method="post" enctype="multipart/form-data">
      <div class="form-item">
        <label for="email">Votre mail :</label>
        <input type="email" name="email" id="email" placeholder="Votre mail ici" required spellcheck="true">
      </div>
      <div class="form-item">
        <label for="password">Votre mot de passe :</label>
        <input type="password" name="password" id="password" placeholder="Votre mot de passe ici" required>
      </div>
      <div class="form-item">
        <label for="c_password">Confirmez votre mot de passe :</label>
        <input type="password" name="c_password" id="c_password" placeholder="Confirmer votre mot de passe ici" required>
      </div>
      <div>
        <p>Votre mot de passe doit comporter :</p>
        <ul>
          <li>Au minimum 8 caractères</li>
          <li>Au minimum une lettre minuscule</li>
          <li>Au minimum une lettre majuscule</li>
          <li>Au minimum un caractère spécial</li>
          <li>Au minimum un chiffre</li>
        </ul>
      </div>
      <input type="submit" name="register" value="M'inscrire !">
    </form>
    <?php if (isset($errormsg)) : echo $errormsg;
    endif ?>
  </main>
</body>

</html>