<?php


namespace Views\components;

require '../vendor/autoload.php';


class ViewPanier extends \app\controllers\Controllerpanier
{

  /**
   * Permet d'afficher le contenu du panier
   */
  public function showPanier()
  {

    $ids = array_keys($_SESSION['panier']);

    if (empty($ids)) {
      $products = array();
    } else {
      $products = $this->getProductById($ids);
    }
    foreach ($products as $product) { ?>

      <div id="rowP" class="row">
        <a href="#" class="img"><img id="imgP" src="../images/imageboutique/<?= $product->img_product ?>"></a>
        <span class="name"><?= $product->name ?></span>
        <span class="price"><?= number_format($product->price, 2, ',', ' ') ?> €</span>

        <span class="quantity">
          <?php if (!isset($_GET['delivery']) && !isset($_GET['expedition']) && !isset($_GET['checkout']) && !isset($_GET['command'])) : ?>
            <input type='number' id='quantity' name='panier[quantity][<?= $product->id_product ?>]' min='1' value='<?= $_SESSION['panier'][$product->id_product]; ?>'>
          <?php else : ?>
            <?= $_SESSION['panier'][$product->id_product]; ?>
          <?php endif; ?>
        </span>

        <span class="subtotalQuantity"><?= $this->getTotalPriceByProduct($product->price, $product->id_product) ?> €</span>
        <?php if (!isset($_GET['delivery']) && !isset($_GET['expedition']) && !isset($_GET['checkout']) && !isset($_GET['command'])) : ?>
          <span class="action">
            <a href="panier.php?del=<?= $product->id_product ?>" class="del"><i class="fas fa-trash-alt"></i></a>
          </span>
        <?php endif; ?>
      </div>
    <?php
    } ?>

    <?php if (!isset($_GET['delivery']) && !isset($_GET['expedition']) && !isset($_GET['checkout']) && !isset($_GET['command']) && !empty($_SESSION['panier'])) : ?>
      <input class="buttonFilter" type="submit" value="Modifier la quantité" name="modifier">
    <?php endif; ?>

    <span class="subTotal">Sous-Total : <b><?= number_format($this->totalPrice(), 2, ',', ' ') ?> €</b></span><br>
  <?php
  }

  /**
   * Permet d'afficher les titres des adresses déjà existantes d'un utilisateur afin qu'il choisisse
   */
  public function showAdressUser()
  {
    if (isset($_SESSION['user']) && !empty($_SESSION['user']->getId_user())) {

      $contprofil = new \app\controllers\controllerprofil();
      $user_adresses = $contprofil->getAdressById_user($_SESSION['user']->getId_user());

      if (gettype($user_adresses) === 'array') {
        foreach ($user_adresses as $adress) {
          echo "<div>
                             <label>
                                <input name='choose_adress' type='radio' value='" . $adress->getTitle() . "' />
                                <span>" . $adress->getTitle() . "</span>
                              </label>
                           </div>";
        }
      }
    }
  }

  /**
   * Affichage du formulaire d'ajout d'adresse.
   */
  public function showFormAddAdress()
  { ?>

    <div id="formNewAdress">
      <h6 id="addAdressTitle">Ajouter une nouvelle adresse d'expédition : </h6>
      <br>
      <form action="panier.php?delivery=infos" method="post">

        <?php if (!isset($_SESSION['user']) && empty($_SESSION['user'])) : ?>
          <div class="form-item">
            <label for="title">Votre nom :</label>
            <input type="text" name="lastname" id="title" placeholder="Nom de famille">
          </div>
          <div class="form-item">
            <label for="country">Votre prénom :</label>
            <input type="text" name="firstname" id="country" placeholder="Prénom">
          </div>
          <div class="input-field">
            <label for="email">Votre email :</label>
            <input type="email" name="email" id="email" spellcheck="TRUE">
          </div>
        <?php endif; ?>

        <div class="form-item">
          <label for="title">Donnez un nom à cette adresse :</label>
          <input type="text" name="title" id="title" placeholder="ex : Appartement perso">
        </div>
        <div class="form-item">
          <label for="country">Pays :</label>
          <input type="text" name="country" id="country" placeholder="ex : France">
        </div>
        <div class="form-item">
          <label for="town">Ville :</label>
          <input type="text" name="town" id="town" placeholder="ex : Marseille">
        </div>
        <div class="form-item">
          <label for="postal_code">Code Postal :</label>
          <input type="text" name="postal_code" id="postal_code" placeholder="ex : 13001">
        </div>
        <div class="form-item">
          <label for="street">Rue :</label>
          <input type="text" name="street" id="street" placeholder="ex : Rue d'Hozier">
        </div>
        <div class="form-item">
          <label for="infos">Infos supplémentaires :</label>
          <input type="text" name="infos" id="infos" placeholder="ex : Appartement 8">
        </div>
        <div class="form-item">
          <label for="number">Numéro de rue :</label>
          <input type="number" name="number" id="number" spellcheck="true">
        </div>
        <input class="buttonFilter" type="submit" value="Ajouter l'adresse" name="add_new_adress">

        <?php if (isset($_GET['delivery']) && isset($_POST['add_new_adress']) && !isset($_SESSION['user']) && empty($_SESSION['user'])) {
          try {
            $this->insertAdressFromPanier(null, $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['title'], $_POST['country'], $_POST['town'], $_POST['postal_code'], $_POST['street'], $_POST['infos'], $_POST['number']);
            Header('Location: panier.php?delivery=infos');
          } catch (\Exception $e) {
            $error_msg = $e->getMessage();
          }
        } ?>

        <?php if (isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_POST['add_new_adress'])) {
          try {
            $this->insertAdressFromPanierUser($_SESSION['user']->getId_user(), $_POST['title'], $_POST['country'], $_POST['town'], $_POST['postal_code'], $_POST['street'], $_POST['infos'], $_POST['number']);
            Header('Location: panier.php?delivery=infos');
          } catch (\Exception $e) {
            $error_msg = $e->getMessage();
          }
        } ?>

        <?php if (isset($error_msg)) : ?>
          <p class="error_msg_shop2">
            <?= $error_msg; ?>
          </p>
        <?php endif; ?>
      </form>
    </div>
<?php
  }

  /**
   * Affichage de l'adresse complète d'un utilisateur
   * @param $id_user
   */
  public function showDetailsExpedition($id_user)
  {
    $details = $this->selectCommandUser($id_user, $_SESSION['totalCommand']);
    if ($details[0]['total_amount'] == strval($_SESSION['totalCommand']) && $details[0]['date_order'] == date("Y-m-d")) {
      $this->showDetailsAdress($details[0]['id_order'], $details[0]['firstname'], $details[0]['lastname'], $details[0]['title'], $details[0]['number'], $details[0]['street'], $details[0]['postal_code'], $details[0]['town'], $details[0]['country'], $details[0]['infos']);
    }
  }

  /**
   * Affichage de l'adresse complète d'un invité
   */
  public function showDetailsGuest()
  {
    $guest = $this->getGuestBdd();

    foreach ($guest as $key => $value) {
      if ($value->guest_firstname == $_SESSION['firstname'] && $value->guest_lastname == $_SESSION['lastname']) {
        $details = $this->selectCommandGuest($value->id_guest);

        foreach ($details as $k => $v) {
          if ($v['total_amount'] == strval($_SESSION['totalCommand']) && $v['date_order'] == date("Y-m-d")) {
            $this->showDetailsAdress($v['id_order'], $v['guest_firstname'], $v['guest_lastname'], $v['title'], $v['number'], $v['street'], $v['postal_code'], $v['town'], $v['country'], $v['infos']);
          }
        }
      }
    }
  }

  /**
   * Affichage html pour l'adresse
   * @param $id_order
   * @param $guest_firstname
   * @param $guest_lastname
   * @param $title
   * @param $number
   * @param $street
   * @param $postal_code
   * @param $town
   * @param $country
   * @param $infos
   */
  public function showDetailsAdress($id_order, $guest_firstname, $guest_lastname, $title, $number, $street, $postal_code, $town, $country, $infos)
  {

    echo "<div id='expeDetails'>
                   <h6>Commande n° :  <b>$id_order</b></h6>
                   <br>
                   <h5 id='titleDetailsAdress'>Adresse de livraison :</h5>
                   <div id='nameRow'>
                       <p id='fName'>$guest_firstname </p>
                       <p id='Lname'>$guest_lastname</p>
                   </div>
                   <p id='titleAd'><b>Titre :</b> $title</p>
                   <p id='nbStreet'><b>N° de la rue :</b> $number </p>
                   <p id='nStreet'><b>Nom de la rue :</b> $street </p>
                   <p><b>Code postal :</b> $postal_code</p>
                   <p><b>Ville :</b> $town </p>
                   <p><b>Pays :</b> $country</p>
                   <p>$infos</p>
                 </div>";
  }


  /**
   * Affichage spécifique quand le panier est vide.
   */
  public function emptyPanier()
  {

    if (!isset($_SESSION['panier']) || empty($_SESSION['panier'])) {

      echo "<div id='emptyP'>
                        <div id='textImgText'>
                               <img src='../images/imagessite/panierEmpty.gif' alt='animation panier vide' id='emptyPanier'>
                           <p id='textEmpty'>Votre panier est vide.</p>
                        </div>
                   </div>";
    }
  }
}
