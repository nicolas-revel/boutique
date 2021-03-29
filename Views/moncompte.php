<?php
require_once('../config/config.php');

if (isset($_GET['modif'])) {
  $upd_adress = $contprofil->getAdressById_adress($_GET['modif']);
  if ($_SESSION['user']->getId_user() === $upd_adress->getId_user()) {
    $check_user = true;
  }
}

if (!isset($_POST['gender'])) {
  $_POST['gender'] = null;
}

if (isset($_POST['update_profile'])) {
  try {
    $_SESSION['user'] = $contprofil->updateUser($_SESSION['user'], $_POST['actual_password'], $_POST['email'], $_POST['new_password'], $_POST['c_new_password'], $_POST['firstname'], $_POST['lastname'], $_POST['phone'], isset($_FILES['avatar']) ? $_FILES['avatar'] : null, $_POST['birthdate'], $_POST['gender']);
  } catch (\Exception $e) {
    $error_msg_user = $e->getMessage();
  }
}

if (isset($_POST['add_new_adress'])) {
  try {
    $contprofil->insertAdress($_SESSION['user']->getId_user(), null, $_POST['title'], $_POST['country'], $_POST['town'], $_POST['postal_code'], $_POST['street'], $_POST['infos'], $_POST['number']);
  } catch (\Exception $e) {
    $error_msg_adress = $e->getMessage();
  }
}

if (isset($_POST['update_adress'])) {
  $contprofil->updateAdress($upd_adress, $_POST['title'], $_POST['country'], $_POST['town'], $_POST['postal_code'], $_POST['street'], $_POST['infos'], $_POST['number']);
  header('Location:moncompte.php');
}

if (isset($_GET['del_adress'])) {
  $contprofil->deleteAdress($_GET['del_adress']);
  header('Location:moncompte.php');
}

if (isset($_SESSION['user']) && !empty($_SESSION['user']->getId_user())) {
  $user_adresses = $contprofil->getAdressById_user($_SESSION['user']->getId_user());
  $user_orders = $contprofil->getOrderById_user($_SESSION['user']->getId_user());
}

$pageTitle = "MON COMPTE";
ob_start();
require_once('../config/header.php');

?>
<main id="main_compte">
  <h1>Mon compte</h1>
  <?php if (isset($_SESSION['user']) && !empty($_SESSION['user']->getEmail())) : ?>
    <section id="user_infos">
      <div id="disp_informations">
        <h2 id="infos">Mes informations personnelles :</h2>
        <?php if (!empty($_SESSION['user']->getAvatar())) : ?>
          <img src="../images/imageavatar/<?= $_SESSION['user']->getAvatar(); ?>" alt="Votre avatar">
        <?php else : ?>
          <p>Vous n'avez pas encore uploadé d'avatar !</p>
        <?php endif; ?>
        <p>Mon email : <?= $_SESSION['user']->getEmail(); ?></p>
        <?php if (!empty($_SESSION['user']->getFirstname())) : ?>
          <p>Mon prénom : <?= $_SESSION['user']->getFirstname(); ?></p>
        <?php else : ?>
          <p>Mon prénom : Vous n'avez pas encore renseigné votre prénom.</p>
        <?php endif; ?>
        <?php if (!empty($_SESSION['user']->getLastname())) : ?>
          <p>Mon nom : <?= $_SESSION['user']->getLastname(); ?></p>
        <?php else : ?>
          <p>Mon nom : Vous n'avez pas encore renseigné votre nom.</p>
        <?php endif; ?>
        <?php if (!empty($_SESSION['user']->getPhone())) : ?>
          <p>Mon numéro de téléphone : <?= $_SESSION['user']->getPhone(); ?></p>
        <?php else : ?>
          <p>Mon nom : Vous n'avez pas encore renseigné votre numéro de téléphone.</p>
        <?php endif; ?>
        <?php if (!empty($_SESSION['user']->getBirthdate())) : ?>
          <p>Ma date de naissance : <?= $_SESSION['user']->getBirthdate(); ?></p>
        <?php else : ?>
          <p>Ma date de naissance : Vous n'avez pas encore renseigné votre date de naissance.</p>
        <?php endif; ?>
        <?php if (!empty($_SESSION['user']->getGender())) : ?>
          <p>Mon genre : <?= $_SESSION['user']->getGender(); ?></p>
        <?php else : ?>
          <p>Mon genre : Vous n'avez pas encore renseigné votre genre.</p>
        <?php endif; ?>
      </div>
      <div class="vertical-separator"></div>
      <div id="modif_informations">
        <h2>Modifier mes informations personnelles :</h2>
        <form action="moncompte.php" method="post" enctype="multipart/form-data">
          <div class="disp_colon">
            <div id="email_pass_fields">
              <div class="input-field">
                <label for="email">Modifier mon email :</label>
                <input type="email" name="email" id="email" spellcheck="TRUE">
              </div>
              <div class="input-field">
                <label for="new_password">Modifier mon mot de passe :</label>
                <input type="password" name="new_password" id="new_password">
              </div>
              <div class="input-field">
                <label for="c_new_password">Confirmer mon nouveau mot de passe :</label>
                <input type="password" name="c_new_password" id="c_new_password">
              </div>
            </div>
            <div>
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
          <div class="disp_colon">
            <div class="input-field">
              <label for="firstname">Modifier mon prénom :</label>
              <input type="text" name="firstname" id="firstname">
            </div>
            <div class="input-field">
              <label for="lastname">Modifier mon nom :</label>
              <input type="text" name="lastname" id="lastname">
            </div>
          </div>
          <div class="input-field">
            <label for="phone">Modifier mon numéro de téléphone :</label>
            <input type="text" name="phone" id="phone">
          </div>
          <div id="upload_avatar">
            <div class="file-field input-field">
              <div class="btn orange darken-1">
                <span>Modifier mon avatar</span>
                <input type="file" />
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text" placeholder="Votre avatar" />
              </div>
            </div>
          </div>
          <div id="avatar_condition">
            <p>Votre avatar doit être d'une taille inférieure à 1 Go. Les formats accéptés sont ".jpeg" ".jpg" ".png"</p>
          </div>
          <div class="disp_colon">
            <div id="inp_date">
              <label for="date">Modifier ma date de naissance</label>
              <input type="date" name="birthdate" id="birthdate">
            </div>
            <div id="inp_radio">
              <p>Modifier mon genre :</p>
              <label for="masculin">
                <input name="gender" type="radio" id="masculin" value="Masculin">
                <span>Masculin</span>
              </label>
              <label for="feminin">
                <input name="gender" type="radio" id="feminin" value="Féminin">
                <span>Féminin</span>
              </label>
              <label for="other">
                <input name="gender" type="radio" id="other" value="Autre">
                <span>Autre</span>
              </label>
            </div>
          </div>
          <p>Pour enregistrer les modification, merci de fournir votre mot de passe actuel :</p>
          <div class="input-field">
            <label for="actual_password">Mon mot de passe :</label>
            <input type="password" name="actual_password" id="actual_password" required>
          </div>
          <button class="btn waves-effect waves-light orange darken-1" type="submit" name="update_profile">Mettre à jour mon profil !</button>
        </form>
        <?php if (isset($error_msg_user)) : ?>
          <div>
            <p class="error_msg">
              <?= $error_msg_user; ?>
            </p>
          </div>
        <?php endif; ?>
      </div>
    </section>
    <section id="order_dashboard">
      <h2 id="user_orders">Gestion des commandes</h2>
      <?php if (!empty($user_orders)) : ?>
        <table class="responsive-table">
          <thead>
            <tr>
              <th>Lien vers le détail de la commande :</th>
              <th>Date de la commande :</th>
              <th>Status de la commande :</th>
              <th>Total de la commande :</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($user_orders as $order) : ?>
              <tr>
                <td class="orderdetail_link"><a href="orderdetail.php?id_order=<?= $order['id_order'] ?>" target="_blank">Commande du <?= $order['date_order'] ?></a></td>
                <td>
                  <p><?= $order['date_order'] ?></p>
                </td>
                <td>
                  <p><?= $order['status'] ?></p>
                </td>
                <td>
                  <p><?= $order['total_amount'] ?> €</p>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      <?php else : ?>
        <p id="order_dashboard_alert">Vous n'avez pas encore réalisé de commande !</p>
      <?php endif ?>
    </section>
    <section id="adresses">
      <h2>Gestion des adresses</h2>
      <div id="user_adresses_title">
        <h3>Mes adresses :</h3>
        <div id="user_adresses">
          <?php if (gettype($user_adresses) === 'array') : ?>
            <?php foreach ($user_adresses as $adress) : ?>
              <div class="card">
                <div class="card-content white-text">
                  <span class="card-title"><?= $adress->getTitle() ?></span>
                  <ul>
                    <li>Pays : <?= $adress->getCountry() ?></li>
                    <li>Ville : <?= $adress->getTown() ?></li>
                    <li>Code postal : <?= $adress->getPostal_code() ?></li>
                    <li>Rue : <?= $adress->getStreet() ?></li>
                    <?php if ($adress->getInfos() !== null) : ?>
                      <li>Infos supplémentaires : <?= $adress->getInfos() ?></li>
                    <?php endif; ?>
                    <li>Numéro de rue : <?= $adress->getNumber() ?></li>
                  </ul>
                </div>
                <div class="card-action">
                  <a href="moncompte.php?modif=<?= $adress->getId_adress() ?>#user_adresses">Modifier cette adresse</a> </br>
                  <a href="<?= $_SERVER['REQUEST_URI'] ?>?del_adress=<?= $adress->getId_adress() ?>">Supprimer cette adresse</a>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
      <div id="form_adresses">
        <?php if (isset($check_user, $upd_adress)) : ?>
          <h3>Modifer <?= $upd_adress->getTitle() ?> :</h3>
          <form action="moncompte.php?modif=<?= $upd_adress->getId_adress(); ?>" method="POST">
            <div class="col-form">
              <div class="input-field">
                <label for="title">Modifier le nom :</label>
                <input type="text" name="title" id="title" required value="<?= $upd_adress->getTitle() ?>">
              </div>
              <div class="input-field">
                <label for="country">Modifier le pays :</label>
                <input type="text" name="country" id="country" required value="<?= $upd_adress->getCountry() ?>">
              </div>
              <div class="input-field">
                <label for="town">Modifier la ville :</label>
                <input type="text" name="town" id="town" required value="<?= $upd_adress->getTown() ?>">
              </div>
              <div class="input-field">
                <label for="postal_code">Modifier le code postal :</label>
                <input type="text" name="postal_code" id="postal_code" required value="<?= $upd_adress->getPostal_code() ?>">
              </div>
            </div>
            <div class="col-form">
              <div class="input-field">
                <label for="street">Modifier la rue :</label>
                <input type="text" name="street" id="street" required value="<?= $upd_adress->getStreet() ?>">
              </div>
              <div class="input-field">
                <label for="infos">Infos supplémentaires :</label>
                <input type="text" name="infos" id="infos" value="<?= $upd_adress->getInfos() ?>">
              </div>
              <div class="input-field">
                <label for="number">Numéro de rue :</label>
                <input type="number" name="number" id="number" spellcheck="true" required value="<?= $upd_adress->getNumber() ?>">
              </div>
              <button class="btn waves-effect waves-light orange darken-1" type="submit" name="update_adress">Modifier cette adresse</button>
            </div>
          </form>
        <?php else : ?>
          <h3>Ajouter une adresse :</h3>
          <form action="moncompte.php" method="POST">
            <div class="col-form">
              <div class="input-field">
                <label for="title">Donnez un nom à cette adresse :</label>
                <input type="text" name="title" id="title" required>
              </div>
              <div class="input-field">
                <label for="country">Pays :</label>
                <input type="text" name="country" id="country" required>
              </div>
              <div class="input-field">
                <label for="town">Ville :</label>
                <input type="text" name="town" id="town" required>
              </div>
              <div class="input-field">
                <label for="postal_code">Code Postal :</label>
                <input type="text" name="postal_code" id="postal_code" required>
              </div>
            </div>
            <div class="col-form">
              <div class="input-field">
                <label for="street">Rue :</label>
                <input type="text" name="street" id="street" required>
              </div>
              <div class="input-field">
                <label for="infos">Infos supplémentaires :</label>
                <input type="text" name="infos" id="infos">
              </div>
              <div class="input-field">
                <label for="number">Numéro de rue :</label>
                <input type="number" name="number" id="number" spellcheck="true" required>
              </div>
              <button class="btn waves-effect waves-light orange darken-1" type="submit" name="add_new_adress">Ajouter l'adresse !</button>
            </div>
            <?php if (isset($error_msg_adress)) : ?>
              <div>
                <p class="error_msg">
                  <?= $error_msg_adress; ?>
                </p>
              </div>
            <?php endif; ?>
          </form>
        <?php endif; ?>
      </div>
    </section>
  <?php else : ?>
    <p>
      Vous ne devriez pas vous trouver sur cette page.
    </p>
  <?php endif; ?>
</main>
<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
