<?php

use app\classes\product;

require_once('../config/config.php');


if (isset($_GET['id_order'])) {
  $order_detail = $contorderdetail->getOrderDetail((int)$_GET['id_order']);
}

$pageTitle = "DETAIL COMMANDE {$order_detail[0]['date_order']}";
ob_start();
require_once('../config/header.php');
?>
<main id="main_orderdetail">
  <?php if (isset($_SESSION['user']) && $_SESSION['user']->getId_user() == $order_detail[0]['id_user'] || $_SESSION['user']->getId_rights() == 42) : ?>

    <section id="order-resume">
      <h1>Détail de la commande</h1>
      <h2>Résumé de la commande :</h2>
      <div>
        <p><b>Date de la commande :</b> <?= $order_detail[0]['date_order'] ?></p>
        <p><b>Etat de la commande :</b> <?= $order_detail[0]['status'] ?></p>
        <p><b>Montant total de la commande :</b> <?= $order_detail[0]['total_amount'] ?> €</p>
      </div>
    </section>
    <section id="order-content">
      <h2>Contenu de la commande :</h2>
      <?php foreach ($order_detail as $product) : ?>
        <div class="order-item">
          <img src="../images/imageboutique/<?= $product['img_product'] ?>" alt="image produit">
          <p><?= $product['product_availability'] != 2 ? $product['name'] : "<strong><em>Ce produit n'est plus disponible dans notre boutique</em></strong>" ?></p>
          <p><b>Prix par pièce :</b> <?= number_format($product['price'], 2, ',', ' ') . " € " ?></p>
          <p><b>Quantité :</b> <?= $product['quantity'] ?></p>
          <p><b>Prix total :</b> <?= number_format($product['amount'], 2, ',', ' ') . " € " ?></p>
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
