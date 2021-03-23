<?php

use app\classes\product;

require_once('components/classesViewHeader.php');
require_once('../vendor/autoload.php');

session_start();

$contorderdetail = new \app\controllers\Controllerdetailorder;

if (isset($_GET['id_order'])) {
  $order_detail = $contorderdetail->getOrderDetail($_GET['id_order']);
}

$pageTitle = "DETAIL COMMANDE {$order_detail[0]['date_order']}";
ob_start();
require_once('../config/header.php');
?>
<main id="main_orderdetail">
  <?php if (isset($_SESSION['user']) && $_SESSION['user']->getId_user() == $order_detail[0]['id_user'] || $_SESSION['user']->getId_rights() == 42) : ?>
    <h1>Détail de la commande</h1>
    <section id="order-resume">
      <h2>Résumé de la commande :</h2>
      <div>
        <p>Date de la commande : <?= $order_detail[0]['date_order'] ?></p>
        <p>Etat de la commande : <?= $order_detail[0]['status'] ?></p>
        <p>Montant total de la commande : <?= $order_detail[0]['total_amount'] ?> €</p>
      </div>
    </section>
    <section id="order-content">
      <h2>Contenu de la commande :</h2>
      <?php foreach ($order_detail as $product) : ?>
        <div class="order-item">
          <img src="../images/imageboutique/<?= $product['img_product'] ?>" alt="image produit">
          <p><?= $product['name'] ?></p>
          <p>Prix par pièce : <?= $product['price'] ?></p>
          <p>Quantité : <?= $product['quantity'] ?></p>
          <p>Prix total : <?= $product['amount'] ?></p>
        </div>
      <?php endforeach; ?>
    </section>
  <?php else : ?>
  <?php endif ?>
</main>
<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
