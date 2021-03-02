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
  <h1>Détail de votre commande</h1>
  <p>Date de la commande : <?= $order_detail[0]['date_order'] ?></p>
  <p>Etat de la commande : <?= $order_detail[0]['status'] ?></p>
  <p>Montant total de la commande : <?= $order_detail[0]['total_amount'] ?> €</p>
  <?php foreach ($order_detail as $product) : ?>
    <div>
      <img src="../images/imageboutique/<?= $product['img_product'] ?>" alt="image produit">
      <p><?= $product['name'] ?></p>
      <p>Prix par pièce : <?= $product['price'] ?></p>
      <p>Quantité : <?= $product['quantity'] ?></p>
      <p>Prix total : <?= $product['amount'] ?></p>
    </div>
  <?php endforeach; ?>
</main>
<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
