<?php
require_once('../config/config.php');

$pageTitle = 'ACCUEIL';
ob_start();
require_once('../config/header.php');
?>

<main>
  <!-- Carousel nouveaux produits/ Ateliers terrarium -->
  <section id="containerCarousel">
    <div class="carousel carousel-slider" id="demo-carousel-auto" data-indicators="true">
      <div class="carousel-item" id="carouselPictures1">
        <div class="carousel-fixed-item center" id="btnFirst">
          <a class="btn waves-effect transparent white-text green darken-text-4 share-btn" href="boutique.php">DECOUVRIR</a>
        </div>
      </div>
      <div class="carousel-item" id="carouselPictures2">
        <div class="carousel-fixed-item center" id="btnSecond">
          <a class="btn waves-effect transparent white-text green darken-text-4 share-btn" href="boutique.php?categorie=<?= $controlAccueil->getIdTerrarium(); ?>">DECOUVRIR</a>
        </div>
      </div>
    </div>
  </section>
  <article>
    <h3 id="titleAccueil">NOS PRODUITS PHARES</h3>

    <!-- SECTION PRODUIT PHARES -->
    <section id="showTopProduct">
      <?= $showNewProduct->TopProductView(); ?>
    </section>

    <!-- SECTION CATEGORIES -->
    <h3 id="titleAccueilCategorie">CATEGORIES</h3>
    <div id="lienBoutique" class="center">
      <a class="buttonFilter" href="boutique.php">BOUTIQUE</a>
    </div>
    <section id="showCategory">
      <?= $showNewProduct->showCategoryWithPictures(); ?>
    </section>
  </article>
  <section id="lastComment">
    <div id="mapAdress">
      <!-- API GOOGLE MAPS-->
      <div id="map">
        <!-- Ici s'affichera la carte -->
      </div>
      <div id="imgVisite">
        <img id="imgVisisteShop" src="../images/imagessite/visite.png" alt="Image visite">
        <div id="adresseShop">
          <p id="textFooter" class="text-green darken-4"><strong>JUNGLE GARDENER</strong><br>8 RUE D'HOZIER<br>13002 MARSEILLE</p>
        </div>
        <div id="telMail">
          <p class="text-green darken-4"><i class="fas fa-envelope-open-text"></i> contact@jungle.com</p>
          <p class="text-green darken-4"><i class="fas fa-phone-square"></i> 06 46 68 89 03</p>
        </div>
      </div>
    </div>
    <div id="showLastComment">
      <h4 id="titleComment">LES DERNIERS AVIS</h4>
      <?= $showNewProduct->showLastComment(); ?>
    </div>
  </section>
</main>

<script src="../js/Mate.js"></script>
<script type="text/javascript" src="../js/script.js"></script>
<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
