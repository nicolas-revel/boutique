<?php
require_once('../config/config.php');

if (isset($_POST['register'])) {
  try {
    $tryinsert = $continsc->insertUser($_POST['email'], $_POST['password'], $_POST['c_password']);
  } catch (\Exception $e) {
    $errormsg = $e->getMessage();
  }
}
$pageTitle = "INSCRIPTION";

ob_start();
require_once('../config/header.php');

?>
<main id="main_inscription">
  <div class="container">
    <h1>Inscrivez-vous !</h1>
    <div class="form_and_condition">
      <form action="inscription.php" method="post" enctype="multipart/form-data">
        <div class="input-field ">
          <label for="email">Votre mail :</label>
          <input type="email" name="email" id="email" required spellcheck="true">
        </div>
        <div class="input-field">
          <label for="password">Votre mot de passe :</label>
          <input type="password" name="password" id="password" required>
        </div>
        <div class="input-field">
          <label for="c_password">Confirmez votre mot de passe :</label>
          <input type="password" name="c_password" id="c_password" required>
        </div>
        <button class="btn waves-effect waves-light green darken-4" type="submit" name="register">M'inscrire !</button>
      </form>
      <div id="password_cond">
        <p>Votre mot de passe doit comporter :</p>
        <ul class="browser-default">
          <li>Au minimum 8 caractères</li>
          <li>Au minimum une lettre minuscule</li>
          <li>Au minimum une lettre majuscule</li>
          <li>Au minimum un caractère spécial</li>
          <li>Au minimum un chiffre</li>
        </ul>
      </div>
    </div>
    <?php if (isset($errormsg)) : ?>
      <div>
        <p class="error_msg">
          <?= $errormsg; ?>
        </p>
      </div>
    <?php endif; ?>
  </div>
</main>
<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
