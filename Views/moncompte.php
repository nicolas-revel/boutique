<?php

require_once('../vendor/autoload.php');

session_start();

$contprofil = new \app\controllers\controllerprofil();

if (!isset($_POST['gender'])) {
  $_POST['gender'] = null;
}

var_dump($_FILES['avatar']);
var_dump($_POST);

/* if (isset($_POST['updateprofile'])) {
  try {
    $_SESSION['user'] = $contprofil->updateUser($_SESSION['user'], $_POST['actual_password'], $_POST['email'], $_POST['new_password'], $_POST['c_new_password'], $_POST['firstname'], $_POST['lastname'], $_FILES['avatar'], $_POST['birthdate'], $_POST['gender']);
  } catch (\Exception $e) {
    $error_msg = $e->getMessage();
  }
}
*/

if (isset($_POST['add_adress'])) {
  try {
    $contprofil->insertAdress($_POST['title'], $_POST['country'], $_POST['town'], $_POST['street'], $_POST['infos'], $_POST['number']);
  } catch (\Exception $e) {
    $error_msg = $e->getMessage();
  }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mon Compte</title>
</head>

<body>
  <main>
    <?php if (isset($_SESSION['user']) && !empty($_SESSION['user']->getEmail())) : ?>
      <?php if (isset($error_msg)) : echo $error_msg;
      endif; ?>
      <section id="user_infos">
        <h1>Informations utilisateurs</h1>
        <form action="moncompte.php" method="post" enctype="multipart/form-data">
          <p>Mon email : <?= $_SESSION['user']->getEmail(); ?></p>
          <div class="form-item">
            <label for="email">Modifier mon email :</label>
            <input type="email" name="email" id="email" placeholder="Nouveau email" spellcheck="TRUE">
          </div>
          <div class="form-item">
            <label for="new_password">Modifier mon mot de passe :</label>
            <input type="password" name="new_password" id="new_password" placeholder="Nouveau mot de passe">
          </div>
          <div class="form-item">
            <label for="c_new_password">Confirmer mon nouveau mot de passe :</label>
            <input type="password" name="c_new_password" id="c_new_password" placeholder="Confirmer le mot de passe">
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
          <?php if (!empty($_SESSION['user']->getFirstname())) : ?>
            <p>Mon prénom : <?= $_SESSION['user']->getFirstname(); ?></p>
          <?php else : ?>
            <p>Mon prénom : Vous n'avez pas encore renseigné votre prénom.</p>
          <?php endif; ?>
          <div class="form-item">
            <label for="firstname">Mettre à jour mon prénom :</label>
            <input type="text" name="firstname" id="firstname" placeholder="Votre prénom">
          </div>
          <?php if (!empty($_SESSION['user']->getLastname())) : ?>
            <p>Mon nom : <?= $_SESSION['user']->getLastname(); ?></p>
          <?php else : ?>
            <p>Mon nom : Vous n'avez pas encore renseigné votre nom.</p>
          <?php endif; ?>
          <div class="form-item">
            <label for="lastname">Mettre à jour mon nom :</label>
            <input type="text" name="lastname" id="lastname" placeholder="Votre nom">
          </div>
          <p>Mon avatar :</p>
          <?php if (!empty($_SESSION['user']->getAvatar())) : ?>
            <img src="../images/imageavatar/<?= $_SESSION['user']->getAvatar(); ?>" alt="Votre avatar">
          <?php else : ?>
            <p>Vous n'avez pas encore uploadé d'avatar !</p>
          <?php endif; ?>
          <div class="form-item">
            <label for="avatar">Mettre à jour mon avatar :</label>
            <input type="file" name="avatar" id="avatar">
          </div>
          <?php if (!empty($_SESSION['user']->getBirthdate())) : ?>
            <p>Ma date de naissance : <?= $_SESSION['user']->getBirthdate(); ?></p>
          <?php else : ?>
            <p>Ma date de naissance : Vous n'avez pas encore renseigné votre date de naissance.</p>
          <?php endif; ?>
          <div class="form-item">
            <label for="birthdate">Mettre à jour ma date de naissance :</label>
            <input type="date" name="birthdate" id="birthdate">
          </div>
          <?php if (!empty($_SESSION['user']->getGender())) : ?>
            <p>Mon genre : <?= $_SESSION['user']->getGender(); ?></p>
          <?php else : ?>
            <p>Mon genre : Vous n'avez pas encore renseigné votre genre.</p>
          <?php endif; ?>
          <div class="form-item">
            <input type="radio" id="masculin" name="gender" value="masculin">
            <label for="masculin">Masculin</label>
            <input type="radio" id="feminin" name="gender" value="feminin">
            <label for="feminin">Féminin</label>
            <input type="radio" id="other" name="gender" value="other">
            <label for="other">Autre</label>
          </div>
          <p>Pour enregistrer les modification, merci de bien remplir votre mot de passe actuel :</p>
          <div class="form-item">
            <label for="actual_password">Mon mot de passe :</label>
            <input type="password" name="actual_password" id="actual_password" placeholder="Mot de passe actuel" required>
          </div>
          <input type="submit" value="Mettre à jour mon profil !" name="updateprofile">
        </form>
      </section>
      <section id="user_adresses">
        <h1>Gestion des adresses</h1>

        <h2>Créer une nouvelle adresse</h2>
        <form action="moncompte.php" method="POST">
          <div class="form-item">
            <label for="title">Donnez un nom à cette adresse :</label>
            <input type="text" name="title" id="title" placeholder="ex : Appartement perso" required>
          </div>
          <div class="form-item">
            <label for="country">Pays :</label>
            <input type="text" name="country" id="country" placeholder="ex : France" required>
          </div>
          <div class="form-item">
            <label for="town">Ville :</label>
            <input type="text" name="town" id="town" placeholder="ex : Marseille" required>
          </div>
          <div class="form-item">
            <label for="street">Rue :</label>
            <input type="text" name="street" id="street" placeholder="ex : Rue d'Hozier" required>
          </div>
          <div class="form-item">
            <label for="infos">Infos supplémentaires :</label>
            <input type="text" name="infos" id="infos" placeholder="ex : Appartement 8">
          </div>
          <div class="form-item">
            <label for="number">Numéro de rue :</label>
            <input type="number" name="number" id="number" spellcheck="true" required>
          </div>
          <input type="submit" value="Ajouter l'adresse" name="add_new_adress">
        </form>
      </section>
    <?php else : ?>
      <p>
        Vous ne devriez pas vous trouver sur cette page.
      </p>
    <?php endif; ?>
  </main>
</body>

</html>