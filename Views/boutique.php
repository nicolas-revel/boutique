<?php

require_once('components/classesViewHeader.php');
require_once('components/classesViewBoutique.php');
require_once '../vendor/autoload.php';

if(isset($_GET['start']) && !empty($_GET['start'])){
    $currentPage = (int) strip_tags($_GET['start']);
}else{
    $currentPage = 1;
}

$topProduct = new \app\views\components\viewBoutique();

$pageTitle = 'BOUTIQUE';
ob_start();
require_once('../config/header.php');

?>

<?php if(isset($_GET['price20'])){
     $price1 = $topProduct->showFiltrePrice(0, 20);
}
if(isset($_GET['price40'])){
    $price2 = $topProduct->showFiltrePrice(20, 40);
}
if(isset($_GET['price60'])){
    $price3 = $topProduct->showFiltrePrice(40, 60);
}
if(isset($_GET['price100'])){
    $price4 = $topProduct->showFiltrePriceMore100 (60);
}
if(!isset($_GET['price'])) { ?>
    <main>
        <article id="shopPage">
            <section id="filters">
                <h4>FILTRAGE</h4>
                <?= $topProduct->showFiltreCat (); ?>
                <h4>FILTRER PAR PRIX</h4>
                <li><a href="boutique.php?price20=20">Entre 0 et 20 €</a></li>
                <li><a href="boutique.php?price40=40">Entre 20 et 40 €</a></li>
                <li><a href="boutique.php?price60=60">Entre 40 et 60 €</a></li>
                <li><a href="boutique.php?price100=+100">Plus de 60 €</a></li>
            </section>


            <section id="showShop">
                <?= $topProduct->newProductView(); ?>
                <?php $pages = $topProduct->showProductwithPagination(); ?>
                <?php $topProduct-> showPagination(null, null, $start = "?start=", $currentPage, $pages); ?>
            </section>
        </article>
    </main>
 <?php
}
?>







<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');



