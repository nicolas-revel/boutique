<?php


namespace app\views\components;

require'../vendor/autoload.php';


class ViewBoutique extends \app\controllers\Controllerboutique
{

    public function newProductView()
    {

        $modelBoutique = new \app\models\Modelboutique();
        $tableNewProduct = $modelBoutique->getNewProduct();

        foreach($tableNewProduct as $key => $value){

            echo " <div id='cardNewProduct'><a href='../views/produit.php?product=".$value['id_product']."'>
                        <div id='card-image'>
                            <img id='pictureNewProduct' alt='Photo du produit' src='../images/imageboutique/".$value['img_product']."'>
                        </div>
                        <div id='content'>
                            <h6>".$value['name']." - <span id='newText'>NEW !</span></h6>
                            <p>".$value['price']." €</p>
                        </div></a>
                   </div>";
        }

    }


    public function AllProductView()
    {
        $modelAccueil = new \app\models\Modelboutique();
        $tableTopProduct = $modelAccueil->getAllProduct(null, null, null);

        foreach($tableTopProduct as $key => $value){
            $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
        }
    }

    public function modelCardProductShop($id_product, $img_product, $name_product, $price_product) { ?>

        <div id='cardProduct'><a href='../views/produit.php?product="<?= $id_product ?>"'>
            <div id='card-image'>
                <img id='pictureProduct' alt='Photo du produit' src='../images/imageboutique/<?= $img_product ?>'>
            </div>
            <div id='content'>
                <h6><?= $name_product ?></h6>
                <p><?= $price_product ?> €</p>
            </div></a>
        </div>

        <?php
    }

    public function showProductwithPagination (){

        if(isset($_GET['start']) && !empty($_GET['start'])){
            $currentPage = (int) strip_tags($_GET['start']);
        }else{
            $currentPage = 1;
        }

        $nbArticles = $this->nbrProduct();
        $parPage = 9;

        $pages = ceil($nbArticles / $parPage);

        $premier = ($currentPage * $parPage) - $parPage;
        $product = $this->getAllProduct(" LIMIT :premier, :parpage ", $premier, $parPage);

        foreach($product as $key => $value){
            $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
        }

        return $pages;
    }

    public function showPagination(?string $url = null, ?int $get = null, ?string $start = null, $currentPage, $pages)
    {

        ?>
        <nav id="navPagination">
            <ul class="pagination">
                <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                <li class="disabled" <?= ($currentPage == 1) ? "disabled" : "" ?>>
                    <a href="<?= $url . $get ?><?= $start . ($currentPage - 1) ?>"><i class="material-icons">chevron_left</i></a>
                </li>
                <?php for ($page = 1; $page <= $pages; $page++): ?>
                    <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                    <li <?= ($currentPage == $page) ? "active" : "" ?>>
                        <a href="<?= $url . $get ?><?= $start . $page ?>"><?= $page ?></a>
                    </li>
                <?php endfor ?>
                <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                <li class="disabled" <?= ($currentPage == $pages) ? "disabled" : "" ?>>
                    <a href="<?= $url . $get ?><?= $start . ($currentPage + 1) ?>"><i class="material-icons">chevron_right</i></a>
                </li>
            </ul>
        </nav>
        <?php
    }

    public function showFiltreCat () {

        $modelBoutique = new \app\models\Modelboutique();
        $table = $modelBoutique->allCategory();
        $subCat = $this->allSubCategory();

        foreach ($table as $key => $value) {

            echo "<h3><a href='#'>".$value['category_name']."</a></h3>";

            foreach ($subCat as $keySub => $valueSub) {

                if($value['id_category'] === $valueSub['id_category']) {

                    echo "<li><a href='#'>".$valueSub['subcategory_name']."</a></li>";
                }
            }

        }
    }

    public function showFiltrePrice($price1, $price2) {

        $modelBoutique = new \app\models\Modelboutique();
        $tablePrice20 = $modelBoutique->getProductBetweenPrice($price1, $price2);

        foreach($tablePrice20 as $key => $value){
            $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
        }
    }

    public function showFiltrePriceMore100 () {

        $modelBoutique = new \app\models\Modelboutique();
        $tablePrice = $modelBoutique->getProductPriceMore100 ();

        foreach($tablePrice as $key => $value){
            $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);

        }
    }

    public function showFilterTopRating() {

        $modelBoutique = new \app\models\Modelboutique();
        $tableTopRating = $modelBoutique->getProductTopRating();

        foreach($tableTopRating as $key => $value){
            $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
        }

    }

    /**
     * Méthode qui permet d'afficher les categories et ses sous-categories dans le dropdown (Header)
     */
    public function showNameCategorieFilter()
    {

        $modelHeader = new \app\models\Modelboutique();
        $table = $modelHeader->allCategory();

        foreach ($table as $key => $value) {
            echo "<option value='".$value['id_category']."'><a href='boutique.php?catogry=".$value['id_category']."'>".$value['category_name']."</a></option>";
        }

    }

    /**
     * Méthode qui permet d'afficher les categories et ses sous-categories dans le dropdown (Header)
     */
    public function showNameSubCategorieFilter()
    {

        $modelHeader = new \app\models\Modelboutique();
        $subCat = $this->allSubCategory();

            foreach ($subCat as $keySub => $valueSub) {
                    echo "<option value='".$valueSub['id_subcategory']."'>".$valueSub['subcategory_name']."</a>";
            }

    }

    public function traitmentFilterForm ($session)
    {

        $sessionFilter = $session;
        var_dump($sessionFilter);

        foreach ($sessionFilter as $keys => $values) {

            if ($values['typeFiltre'] === 'prixasc') {

                $asc = $this->priceAsc(' WHERE id_category = :id_category AND id_subcategory = :id_subcategory ORDER BY price ASC ', null, null, intval($values['id_category']), intval($values['id_subcategory']));

                foreach ($asc as $key => $value) {
                    $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                }
            }
                if($values['typeFiltre'] === 'prixasc' && !empty($values['id_category']) && empty($values['id_subcategory'])) {

                    $asc = $this->priceAsc(null, ' WHERE id_category = :id_category ORDER BY price ASC ', null, intval($values['id_category']), null);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }

                if ($values['typeFiltre'] === 'prixasc' && !empty($values['id_subcategory']) && empty($values['id_category'])) {

                    $asc = $this->priceAsc(null, null, ' WHERE id_subcategory = :id_subcategory ORDER BY price ASC ', null, intval($values['id_subcategory']));

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }

                if($values['typeFiltre'] === 'prixasc' && empty($values['id_subcategory']) && empty($values['id_category'])){

                    $asc = $this->priceAsc(null, null, null, null, null);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }




                if ($values['typeFiltre'] === 'prixdesc') {

                    $asc = $this->priceAsc(' WHERE id_category = :id_category AND id_subcategory = :id_subcategory ORDER BY price DESC ', null, null, intval($values['id_category']), intval($values['id_subcategory']));

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }

                if ($values['typeFiltre'] === 'prixdesc' && !empty($values['id_category']) && empty($values['id_subcategory'])) {

                    $asc = $this->priceAsc(null, ' WHERE id_category = :id_category ORDER BY price DESC ', null, intval($values['id_category']), null);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }

                if ($values['typeFiltre'] === 'prixdesc' && !empty($values['id_subcategory']) && empty($values['id_category'])) {

                    $asc = $this->priceAsc(null, null, ' WHERE id_subcategory = :id_subcategory ORDER BY price DESC ', null, intval($values['id_subcategory']));

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }

            if($values['typeFiltre'] === 'prixdesc' && empty($values['id_subcategory']) && empty($values['id_category'])){

                $asc = $this->priceAsc(null, null, null, null, null);

                foreach ($asc as $key => $value) {
                    $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                }
            }


            if ($values['typeFiltre'] === 'namealpha') {

                $asc = $this->priceAsc(' WHERE id_category = :id_category AND id_subcategory = :id_subcategory ORDER BY name ASC ', null, null, intval($values['id_category']), intval($values['id_subcategory']));

                foreach ($asc as $key => $value) {
                    $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                }
            }
                if ($values['typeFiltre'] === 'namealpha' && !empty($values['id_category']) && empty($values['id_subcategory'])) {

                    $asc = $this->priceAsc(null, ' WHERE id_category = :id_category ORDER BY name ASC ', null, intval($values['id_category']), null);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }

                if ($values['typeFiltre'] === 'namealpha' && !empty($values['id_subcategory']) && empty($values['id_category'])) {

                    $asc = $this->priceAsc(null, null, ' WHERE id_subcategory = :id_subcategory ORDER BY name ASC ', null, intval($values['id_subcategory']));

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
            if($values['typeFiltre'] === 'namealpha' && empty($values['id_subcategory']) && empty($values['id_category'])){

                $asc = $this->priceAsc(null, null, null, null, null);

                foreach ($asc as $key => $value) {
                    $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                }
            }


            if ($values['typeFiltre'] === 'dateasc') {

                $asc = $this->priceAsc(' WHERE id_category = :id_category AND id_subcategory = :id_subcategory ORDER BY date_product ASC ', null, null, intval($values['id_category']), intval($values['id_subcategory']));

                foreach ($asc as $key => $value) {
                    $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                }
            }
                if ($values['typeFiltre'] === 'dateasc' && !empty($values['id_category']) && empty($values['id_subcategory'])) {

                    $asc = $this->priceAsc(null, ' WHERE id_category = :id_category ORDER BY date_product ASC ', null, intval($values['id_category']), null);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }

                if ($values['typeFiltre'] === 'dateasc' && !empty($values['id_subcategory']) && empty($values['id_category'])) {

                    $asc = $this->priceAsc(null, null, ' WHERE id_subcategory = :id_subcategory ORDER BY date_product ASC ', null, intval($values['id_subcategory']));

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
            if($values['typeFiltre'] === 'dateasc' && empty($values['id_subcategory']) && empty($values['id_category'])){

                $asc = $this->priceAsc(null, null, null, null, null);

                foreach ($asc as $key => $value) {
                    $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                }
            }


            if ($values['typeFiltre'] === 'datedesc') {

                $asc = $this->priceAsc(' WHERE id_category = :id_category AND id_subcategory = :id_subcategory ORDER BY date_product DESC ', null, null, intval($values['id_category']), intval($values['id_subcategory']));

                foreach ($asc as $key => $value) {
                    $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                }
            }

                if ($values['typeFiltre'] === 'datedesc' && !empty($values['id_category']) && empty($values['id_subcategory'])) {

                    $asc = $this->priceAsc(null, ' WHERE id_category = :id_category ORDER BY date_product DESC ', null, intval($values['id_category']), null);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }

                if ($values['typeFiltre'] === 'datedesc' && !empty($values['id_subcategory']) && empty($values['id_category'])) {

                    $asc = $this->priceAsc(null, null, ' WHERE id_subcategory = :id_subcategory ORDER BY date_product DESC ', null, intval($values['id_subcategory']));

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
            if($values['typeFiltre'] === 'datedesc' && empty($values['id_subcategory']) && empty($values['id_category'])){

                $asc = $this->priceAsc(null, null, null, null, null);

                foreach ($asc as $key => $value) {
                    $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                }
            }


            if ($values['typeFiltre'] === 'toprating') {

                $asc = $this->getProductTopRating(' WHERE id_category = :id_category AND id_subcategory = :id_subcategory GROUP BY product.id_product DESC ', null, null, intval($values['id_category']), intval($values['id_subcategory']));

                foreach ($asc as $key => $value) {
                    $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                }
            }
                if ($values['typeFiltre'] === 'toprating' && !empty($values['id_category']) && empty($values['id_subcategory'])) {

                    $asc = $this->getProductTopRating(' WHERE id_category = :id_category GROUP BY product.id_product DESC ', null, null, intval($values['id_category']), intval($values['id_subcategory']));

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if ($values['typeFiltre'] === 'toprating' && !empty($values['id_subcategory']) && empty($values['id_category'])) {

                    $asc = $this->getProductTopRating(' WHERE id_subcategory = :id_subcategory GROUP BY product.id_product DESC ', null, null, intval($values['id_category']), intval($values['id_subcategory']));

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if($values['typeFiltre'] === 'toprating' && empty($values['id_subcategory']) && empty($values['id_category'])){

                    $asc = $this->priceAsc(null, null, null, null, null);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }

        }

            if (empty($values['typeFiltre']) && empty($values['id_subcategory']) && !empty($values['id_category'])) {

                $asc = $this->getProductWithoutFilter(' WHERE id_category = :id_category', intval($values['id_category']), null, null);

                foreach ($asc as $key => $value) {
                    $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                }
            }

            if (empty($value['typeFiltre']) && !empty($values['id_subcategory']) && empty($values['id_category'])) {

                $asc = $this->getProductWithoutFilter(null, null, ' WHERE id_subcategory = :id_subcategory', intval($values['id_subcategory']));

                foreach ($asc as $key => $value) {
                    $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                }
            }

    }






}