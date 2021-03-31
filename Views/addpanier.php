<?php
require_once('../config/config.php');

$pageTitle = 'PRODUIT';
ob_start();
require_once('../config/header.php');
?>

<main id="mainBoutique">
  <section id="confirmAddProduct">
    <div id='textConfirm'>
      <div id="textButton">
        <?php $controlPanier->showAddPanier(); ?>
        <div id='buttonConnect2'>
          <a class="lienBackShop" href='boutique.php'>
            < boutique</a>
              <a class="lienBackPanier" href='panier.php'>Aller sur le panier ></a>
        </div>
      </div>
      <div id="gifImg">
        <img id="gifAdd" src="../images/imagessite/giphy.gif" alt="animation confirmation ajout">
      </div>
    </div>
  </section>
</main>


<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
