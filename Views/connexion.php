<?php
require_once('components/classesViewHeader.php');
require_once('../vendor/autoload.php');

session_start();

$contconnexion = new \app\controllers\Controllerconnexion();

if (isset($_POST['loguser'])) {
  try {
    $_SESSION['user'] = $contconnexion->connectUser($_POST['email'], $_POST['password']);
    header('Location:../index.php');
  } catch (\Exception $e) {
    $errormsg = $e->getMessage();
  }
}

$pageTitle = "CONNEXION";

ob_start();
require_once('../config/header.php');

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
  <main id="main_connexion">
    <div class="container">
      <h1>Connectez-vous !</h1>
      <form action="connexion.php" method="post">
        <div class="input-field">
          <label for="email">Votre mail :</label>
          <input type="email" name="email" id="email" required spellcheck="true">
        </div>
        <div class="input-field">
          <label for="password">Votre mot de passe :</label>
          <input type="password" name="password" id="password" required>
        </div>
        <button class="btn waves-effect waves-light green darken-4" type="submit" name="loguser">Me connecter !</button>
      </form>
      <?php if (isset($errormsg)) : ?>
        <div>
          <p class="error_msg">
            <?= $errormsg; ?>
          </p>
        </div>
      <?php endif; ?>
    </div>
  </main>
</body>

</html>
<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
