<?php
require_once('../Views/components/classesViewHeader.php');
require_once('components/classesViewBoutique.php');
require_once '../vendor/autoload.php';
session_start();

$viewProduct = new \app\views\components\viewBoutique();

$pageTitle = 'BOUTIQUE';
ob_start();
require_once('../config/header.php');

if(isset($_GET['start']) && !empty($_GET['start'])){ $currentPage = (int) strip_tags($_GET['start']);}else{ $currentPage = 1;} ?>

    <main id="mainBoutique">

        <article id="shopPage">
            <section id="filters">
                <?php $viewProduct->showFilterForm (); ?>
            </section>

            <section id="showShop">
                <?php if(!isset($_GET['search']) && !isset($_GET['filter']) && !isset($_GET['categorie'])): ?>
                    <div id="imgNew">
                        <img id="imgNewProduct" src="../images/imagessite/new.png" alt="Image nouvel arrivage">
                    </div>
                    <div id="newProductBlock">
                        <?= $viewProduct->newProductView(); ?>
                    </div>
                    <div id="shop">
                        <?php $pages = $viewProduct->showProductwithPagination(); ?>
                    </div>
                <?php endif; ?>

                <!-- AFFICHAGE AVEC FILTRAGE -->
                <?php if(isset($_GET['filter']) && isset($_SESSION['filter'])): ?>
                    <div class="shop2">
                    <?php $pages = $viewProduct->traitmentFilterForm($_SESSION['filter']); ?>
                    </div>
                <?php endif; ?>
                <?php if(isset($_GET['search']) && !isset($_GET['filter']) && !isset($_GET['categorie'])): ?>
                    <div class="shop2">
                    <?php $viewProduct->showResultSearchBar(); ?>
                    </div>
                <?php endif; ?>

                <!-- AFFICHAGE AVEC GET CATEGORY(requête effectué sur la page d'accueil) -->
                <?php if(isset($_GET['categorie']) && !isset($_GET['search']) && !isset($_GET['filter'])){ $pages = $viewProduct->showByCategoryHome ();} ?>
            </section>
        </article>

        <div id="pagination" class="flow-text">
            <?php if(isset($_GET['filter']) && isset($_SESSION['filter'])) {
                $viewProduct-> showPagination(null, null, $start = "?start=", $currentPage, $pages);
            } else {
                $viewProduct->showPagination(null, null, $start = "?start=", $currentPage, $pages);
            } ?>

            <?php if(isset($_GET['categorie']) && !isset($_GET['search']) && !isset($_GET['filter'])){
                $viewProduct->showPagination(null, "?categorie=".$_GET['categorie']."", $start = "&start", $currentPage, $pages);}?>
        </div>
    </main>

<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');



