<?php
require_once('components/classesViewHeader.php');
require_once('components/classesViewAccueil.php');
require_once '../vendor/autoload.php';
session_start();

$showNewProduct = new \app\views\components\viewAccueil();
$controlAccueil = new \app\controllers\Controlleraccueil();

$pageTitle = 'ACCUEIL';
ob_start();
require_once('../config/header.php');
?>

<main>
    <!-- Carousel nouveaux produits/ Ateliers terrarium -->
    <section id="containerCarousel">
    <div class="carousel carousel-slider" id="demo-carousel-auto" data-indicators="true" >
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
        <section id="showTopProduct">
        <?= $showNewProduct->TopProductView(); ?>
        </section>

        <h3 id="titleAccueilCategorie">CATEGORIES</h3>
        <section id="showCategory">
            <?= $showNewProduct->showCategoryWithPictures(); ?>
        </section>
    </article>

    <section id="lastComment">
        <div id="shopMaps"></div>
        <div id="showLastComment">
            <h4 id="titleComment">LES DERNIERS AVIS</h4>
            <?= $showNewProduct->showLastComment(); ?>
        </div>
    </section>



    <script src="../js/Mate.js"></script>
</main>

<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
