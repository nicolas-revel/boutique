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
<?php
if(isset($_GET['filter']) && isset($_SESSION['filter'])){
    $pages = $topProduct->traitmentFilterForm($_SESSION['filter']);
    $topProduct->showPagination(null, null, $start = "&start=", $currentPage, $pages);
}
if(isset($_GET['search'])){
    $topProduct->showResultSearchBar ();
}
?>


<?php if(!isset($_GET['search']) && !isset($_GET['filter'])): ?>
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



