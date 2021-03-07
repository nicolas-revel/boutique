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
                <?php if(!isset($_GET['search']) && !isset($_GET['filter']) && !isset($_GET['categorie']) && !isset($_GET['subcategorie'])): ?>
                    <div id="imgNew">
                        <img id="imgNewProduct" src="../images/imagessite/new.png" alt="Image nouvel arrivage">
                    </div>
                    <div id="newProductBlock">
                        <?= $viewProduct->newProductView(); ?>
                    </div>
                    <div id="shop">
                        <?php $pages = $viewProduct->showProductwithPagination($currentPage); ?>
                    </div>
                <?php endif; ?>

                <!-- AFFICHAGE AVEC FILTRAGE -->
                <?php if(isset($_GET['filter']) && isset($_SESSION['filter'])): ?>
                    <div class="shop2">
                    <?php $pages = $viewProduct->traitmentFilterForm($_SESSION['filter'], $currentPage); ?>
                    </div>
                <?php endif; ?>
                <?php if(isset($_GET['search']) && !isset($_GET['filter']) && !isset($_GET['categorie']) && !isset($_GET['subcategorie'])): ?>
                    <div class="shop2">
                    <?php $pages = $viewProduct->showResultSearchBar(); ?>
                    </div>
                <?php endif; ?>

                <!-- AFFICHAGE AVEC GET CATEGORY(requête effectué sur la page d'accueil) -->
                <?php if(isset($_GET['categorie']) && !isset($_GET['search']) && !isset($_GET['filter']) && !isset($_GET['subcategorie'])) : ?>
                <div class="shop2">
                    <?php $pages = $viewProduct->showByCategoryHome ($currentPage); ?>
                </div>
                <?php endif; ?>

                <!-- AFFICHAGE AVEC GET SUBCATEGORY(requête effectué sur la page d'accueil) -->
                <?php if(isset($_GET['subcategorie']) && !isset($_GET['search']) && !isset($_GET['filter']) && !isset($_GET['categorie'])) : ?>
                    <div class="shop2">
                        <?php $pages = $viewProduct->showBySubCategoryHome ($currentPage); ?>
                    </div>
                <?php endif; ?>
            </section>
        </article>

        <div id="pagination" class="flow-text">

            <?php if(!isset($_GET['search']) && !isset($_GET['filter']) && !isset($_GET['categorie']) && !isset($_GET['subcategorie'])): ?>
                <?php $viewProduct-> showPagination(null, null, $start = "?start=", $currentPage, $pages); ?>
            <?php endif; ?>

            <?php if(isset($_GET['filter']) && isset($_SESSION['filter']) && !isset($_GET['search']) && !isset($_GET['categorie']) && !isset($_GET['subcategorie'])) {
                $viewProduct-> showPagination(null, null, $start = "?start=", $currentPage, $pages);
            }  ?>

            <?php if(isset($_GET['categorie']) && !isset($_GET['search']) && !isset($_GET['filter']) && !isset($_GET['filter']) && !isset($_SESSION['filter']) && !isset($_GET['subcategorie'])){
                $viewProduct->showPagination(null, "?categorie=".$_GET['categorie']."", $start = "&start", $currentPage, $pages);}?>

            <?php if(isset($_GET['subcategorie']) && !isset($_GET['search']) && !isset($_GET['filter']) && !isset($_GET['filter']) && !isset($_SESSION['filter']) && !isset($_GET['categorie'])){
                $viewProduct->showPagination(null, "?categorie=".$_GET['categorie']."", $start = "&start", $currentPage, $pages);}?>
        </div>
    </main>

<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');



