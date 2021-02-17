<?php
session_start();

require_once('components/classesViewHeader.php');
require_once('components/classesViewBoutique.php');
require_once '../vendor/autoload.php';

if(isset($_GET['start']) && !empty($_GET['start'])){
    $currentPage = (int) strip_tags($_GET['start']);
}else{
    $currentPage = 1;
}

$topProduct = new \app\views\components\viewBoutique();
$filter = new \app\controllers\Controllerboutique();

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
if(isset($_GET['toprating'])){
    $topRating = $topProduct->showFilterTopRating();
}
if(isset($_GET['filter']) && isset($_SESSION['filter'])){
    $topProduct->traitmentFilterForm($_SESSION['filter']);
}
?>


<?php if(!isset($_GET['price20']) && !isset($_GET['price40']) && !isset($_GET['price60']) && !isset($_GET['price100']) && !isset($_GET['toprating']) && !isset($_GET['filter'])): ?>
    <main>
        <article id="shopPage">
            <section id="filters">
                <h4>FILTRAGE</h4>

                <form action="boutique.php" method="post">
                    <div class="input-field col s12">
                        <select name="chooseCat">
                            <option value="" disabled selected>Categorie: </option>
                            <?= $topProduct->showNameCategorieFilter(); ?>
                        </select>
                        <label>Categories / Sous-categories :</label>
                    </div>
                    <div class="input-field col s12">
                            <select name="chooseSubCat">
                                <option value="" disabled selected>Sous-categorie: </option>
                                <?= $topProduct->showNameSubCategorieFilter(); ?>
                            </select>
                        <label>Categories / Sous-categories :</label>
                    </div>
                    <br>
                    <div class="input-field col s12">
                            <select name="chooseTypeFilter">
                                <option value="" disabled selected>Type de filtrage: </option>
                                <option value="prixasc">Par prix croissant</option>
                                <option value="prixdesc">Par prix décroissant</option>
                                <option value="namealpha">Par ordre alphabétique</option>
                                <option value="dateasc">Par date croissante</option>
                                <option value="datedesc">Par date décroissante</option>
                                <option value="toprating">Produits les mieux notés</option>
                                <option value="topsail">Nos produits phares</option>
                            </select>
                        <label>Filtrer :</label>
                    </div>
                    <input type="submit" name="filtrer" value="FILTRER">
                    <?php if(isset($_POST['filtrer'])){$filter->getFiltersForm ();} ?>
                </form>

                <?= $topProduct->showFiltreCat (); ?>
                <h4>FILTRER PAR PRIX</h4>
                <li><a href="boutique.php?price20=20">Entre 0 et 20 €</a></li>
                <li><a href="boutique.php?price40=40">Entre 20 et 40 €</a></li>
                <li><a href="boutique.php?price60=60">Entre 40 et 60 €</a></li>
                <li><a href="boutique.php?price100=+100">Plus de 60 €</a></li>
                <br>
                <li><a href="boutique.php?toprating=1">Les mieux notés</a></li>
                <li><a href="boutique.php?topshop=1">Nos produits phares</a></li>
            </section>


            <section id="showShop">
                <?= $topProduct->newProductView(); ?>
                <?php $pages = $topProduct->showProductwithPagination(); ?>
                <?php $topProduct-> showPagination(null, null, $start = "?start=", $currentPage, $pages); ?>
            </section>
        </article>
    </main>

<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems, options);
    });

    // Or with jQuery

    $(document).ready(function(){
        $('select').formSelect();
    });
</script>







<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');



