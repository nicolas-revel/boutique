<?php
require_once('../config/config.php');

$pageTitle = 'BOUTIQUE';
ob_start();
require_once('../config/header.php');

if(isset($_GET['start']) && !empty($_GET['start'])){ $currentPage = (int) strip_tags($_GET['start']);}else{ $currentPage = 1;}
?>

    <main id="mainBoutique">
        <article id="shopPage">
            <section id="filters">
                <?php $viewProductShop->showFilterForm (); ?>
            </section>

            <section id="showShop">
                <?php if(!isset($_GET['search']) && !isset($_GET['filter']) && !isset($_GET['categorie']) && !isset($_GET['subcategorie'])): ?>
                    <div id="imgNew">
                        <img id="imgNewProduct" src="../images/imagessite/new.png" alt="Image nouvel arrivage">
                    </div>
                    <div id="newProductBlock">
                        <?= $viewProductShop->newProductView(); ?>
                    </div>
                    <div id="shop">
                        <?php $pages1 = $viewProductShop->showProductwithPagination($currentPage); ?>
                    </div>
                <?php endif; ?>

                <!-- AFFICHAGE AVEC FILTRAGE -->
                <?php if(isset($_GET['filter']) && isset($_SESSION['filter'])): ?>
                    <div class="shop2">
                    <?php $pagesFilter = $viewProductShop->traitmentFilterForm($_SESSION['filter'], $currentPage); ?>
                    </div>
                <?php endif; ?>
                <?php if(isset($_GET['search']) && !isset($_GET['filter']) && !isset($_GET['categorie']) && !isset($_GET['subcategorie'])): ?>
                    <h6 id="resultSearchShop">Votre recherche: <b><?= $_GET['search']; ?></b></h6>
                    <div class="shopSearch">
                    <?php $pagesSearch = $viewProductShop->showResultSearchBar(); ?>
                    </div>
                <?php endif; ?>

                <!-- AFFICHAGE AVEC GET CATEGORY(requête effectué sur la page d'accueil) -->
                <?php if(isset($_GET['categorie']) && !isset($_GET['search']) && !isset($_GET['filter']) && !isset($_GET['subcategorie'])) : ?>
                <div class="shop2">
                    <?php $pagesCat = $viewProductShop->showByCategoryHome ($currentPage); ?>
                </div>
                <?php endif; ?>

                <!-- AFFICHAGE AVEC GET SUBCATEGORY(requête effectué sur la page d'accueil) -->
                <?php if(isset($_GET['subcategorie']) && !isset($_GET['search']) && !isset($_GET['filter']) && !isset($_GET['categorie'])) : ?>
                    <div class="shop2">
                        <?php $pagesSub = $viewProductShop->showBySubCategoryHome ($currentPage); ?>
                    </div>
                <?php endif; ?>
            </section>
        </article>

        <div id="pagination" class="flow-text">
            <?php if(!isset($_GET['search']) && !isset($_GET['filter']) && !isset($_GET['categorie']) && !isset($_GET['subcategorie'])) {
                $viewProductShop->showPagination(null, null, $start = "?start=", $currentPage, $pages1);
            }
            if(isset($_GET['filter']) && isset($_SESSION['filter']) && !isset($_GET['search']) && !isset($_GET['categorie']) && !isset($_GET['subcategorie'])){
            if($pagesFilter != 0){
                $viewProductShop-> showPagination(null, $get = "?filter=product", $start = "&start=", $currentPage, $pagesFilter);
            }
            }
            if(isset($_GET['categorie']) && !isset($_GET['search']) && !isset($_GET['filter']) && !isset($_GET['filter']) && !isset($_SESSION['filter']) && !isset($_GET['subcategorie'])) {
            if ($pagesCat != 0) {
                $viewProductShop->showPagination(null, "?categorie=" . $_GET['categorie'] . "", $start = "&start", $currentPage, $pagesCat);
            }
            }
            if(isset($_GET['subcategorie']) && !isset($_GET['search']) && !isset($_GET['filter']) && !isset($_GET['filter']) && !isset($_SESSION['filter']) && !isset($_GET['categorie'])){
            if($pagesSub != 0){
                $viewProductShop->showPagination(null, "?subcategorie=".$_GET['subcategorie']."", $start = "&start", $currentPage, $pagesSub);
            }
            } ?>
        </div>
    </main>

<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');



