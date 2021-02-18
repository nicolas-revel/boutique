<?php


namespace app\views\components;

require'../vendor/autoload.php';


class ViewBoutique extends \app\controllers\Controllerboutique
{

    /**
     * Méthode qui permet d'afficher les nouveaux produits (page Boutique)
     */
    public function newProductView()
    {
        $tableNewProduct = $this->getNewProduct();

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

    /**
     * Modèle affichage des produits (page Boutique)
     * @param $id_product
     * @param $img_product
     * @param $name_product
     * @param $price_product
     */
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

    /**
     * Méthode qui permet d'afficher les produits avec le système de pagination
     * @return false|float
     */
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

    /**
     * Méthode qui permet d'afficher la pagination (page Boutique)
     * @param string|null $url
     * @param int|null $get
     * @param string|null $start
     * @param $currentPage
     * @param $pages
     */
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

    /**
     * Méthode qui permet d'afficher les categories dans le select (Page boutique)
     */
    public function showNameCategorieFilter()
    {
        $table = $this->allCategory();

        foreach ($table as $key => $value) {
            echo "<option value='".$value['id_category']."'><a href='boutique.php?catogry=".$value['id_category']."'>".$value['category_name']."</a></option>";
        }
    }

    /**
     * Méthode qui permet d'afficher les sous-categories dans le select (page boutique)
     */
    public function showNameSubCategorieFilter()
    {
        $subCat = $this->allSubCategory();

            foreach ($subCat as $keySub => $valueSub) {
                    echo "<option value='".$valueSub['id_subcategory']."'>".$valueSub['subcategory_name']."</a>";
            }

    }

    public function traitmentFilterForm ($session)
    {
        $sessionFilter = $session;

        if(isset($_GET['start']) && !empty($_GET['start'])){
            $currentPage = (int) strip_tags($_GET['start']);
        }else{
            $currentPage = 1;
        }

        $parPage = 9;
        $premier = ($currentPage * $parPage) - $parPage;

        foreach ($sessionFilter as $keys => $values) {

            //Filtrage prix croissant: par categorie, sous-categorie, ou sur l'ensemble de la boutique

                if ($values['typeFiltre'] === 'prixasc') {

                    $result = $this->countProduct(' WHERE id_category = :id_category AND id_subcategory = :id_subcategory ', null, null, intval($values['id_category']), intval($values['id_subcategory']) );
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->priceAsc(' WHERE id_category = :id_category AND id_subcategory = :id_subcategory ORDER BY price ASC LIMIT :premier, :parpage', null, null, null, intval($values['id_category']), intval($values['id_subcategory']), $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if($values['typeFiltre'] === 'prixasc' && !empty($values['id_category']) && empty($values['id_subcategory'])) {

                    $result = $this->countProduct(null, ' WHERE id_category = :id_category ', null, intval($values['id_category']), null);
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->priceAsc(null, ' WHERE id_category = :id_category ORDER BY price ASC LIMIT :premier, :parpage', null, null, intval($values['id_category']), null, $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if ($values['typeFiltre'] === 'prixasc' && !empty($values['id_subcategory']) && empty($values['id_category'])) {

                    $result = $this->countProduct(null, null, ' WHERE id_subcategory = :id_subcategory ', null, intval($values['id_category']));
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->priceAsc(null, null, ' WHERE id_subcategory = :id_subcategory ORDER BY price ASC LIMIT :premier, :parpage', null, null, intval($values['id_subcategory']), $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if($values['typeFiltre'] === 'prixasc' && empty($values['id_subcategory']) && empty($values['id_category'])){

                    $result = $this->countProduct(null, null, null, null, null);
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->priceAsc(null, null, null, ' LIMIT :premier, :parpage ', null, null, $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }

            //Filtrage prix décroissant: par categorie, sous-categorie, ou sur l'ensemble de la boutique

                if ($values['typeFiltre'] === 'prixdesc') {

                    $result = $this->countProduct(' WHERE id_category = :id_category AND id_subcategory = :id_subcategory ', null, null, intval($values['id_category']), intval($values['id_subcategory']) );
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->priceAsc(' WHERE id_category = :id_category AND id_subcategory = :id_subcategory ORDER BY price DESC LIMIT :premier, :parpage ', null, null, null, intval($values['id_category']), intval($values['id_subcategory']), $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if ($values['typeFiltre'] === 'prixdesc' && !empty($values['id_category']) && empty($values['id_subcategory'])) {

                    $result = $this->countProduct(null, ' WHERE id_category = :id_category ', null, intval($values['id_category']), null);
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->priceAsc(null, ' WHERE id_category = :id_category ORDER BY price DESC LIMIT :premier, :parpage ', null, null, intval($values['id_category']), null, $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if ($values['typeFiltre'] === 'prixdesc' && !empty($values['id_subcategory']) && empty($values['id_category'])) {

                    $result = $this->countProduct(null, null, ' WHERE id_subcategory = :id_subcategory ', null, intval($values['id_subcategory']));
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->priceAsc(null, null, ' WHERE id_subcategory = :id_subcategory ORDER BY price DESC LIMIT :premier, :parpage ', null, null, intval($values['id_subcategory']), $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if($values['typeFiltre'] === 'prixdesc' && empty($values['id_subcategory']) && empty($values['id_category'])){

                    $result = $this->countProduct(null, null, null, null, null);
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->priceAsc(null, null, null, ' LIMIT :premier, :parpage ', null, null, $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }

            //Filtrage par ordre alphabétique: par categorie, sous-categorie, ou sur l'ensemble de la boutique

                if ($values['typeFiltre'] === 'namealpha') {

                    $result = $this->countProduct(' WHERE id_category = :id_category AND id_subcategory = :id_subcategory ', null, null, intval($values['id_category']), intval($values['id_subcategory']) );
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->priceAsc(' WHERE id_category = :id_category AND id_subcategory = :id_subcategory ORDER BY name ASC LIMIT :premier, :parpage ', null, null, null, intval($values['id_category']), intval($values['id_subcategory']), $premier, $parPage);

                     foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if ($values['typeFiltre'] === 'namealpha' && !empty($values['id_category']) && empty($values['id_subcategory'])) {

                    $result = $this->countProduct(null, ' WHERE id_category = :id_category ', null, intval($values['id_category']), null);
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->priceAsc(null, ' WHERE id_category = :id_category ORDER BY name ASC LIMIT :premier, :parpage ', null, null, intval($values['id_category']), null, $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if ($values['typeFiltre'] === 'namealpha' && !empty($values['id_subcategory']) && empty($values['id_category'])) {

                    $result = $this->countProduct(null, null, ' WHERE id_subcategory = :id_subcategory ', null, intval($values['id_category']));
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->priceAsc(null, null, ' WHERE id_subcategory = :id_subcategory ORDER BY name ASC LIMIT :premier, :parpage ', null, null, intval($values['id_subcategory']), $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if($values['typeFiltre'] === 'namealpha' && empty($values['id_subcategory']) && empty($values['id_category'])){

                    $result = $this->countProduct(null, null, null, null, null);
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->priceAsc(null, null, null, ' LIMIT :premier, :parpage ', null, null, $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }

            //Filtrage par date croissante: par categorie, sous-categorie, ou sur l'ensemble de la boutique

                if ($values['typeFiltre'] === 'dateasc') {

                    $result = $this->countProduct(' WHERE id_category = :id_category AND id_subcategory = :id_subcategory ', null, null, intval($values['id_category']), intval($values['id_subcategory']) );
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->priceAsc(' WHERE id_category = :id_category AND id_subcategory = :id_subcategory ORDER BY date_product ASC LIMIT :premier, :parpage ', null, null, null, intval($values['id_category']), intval($values['id_subcategory']), $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if ($values['typeFiltre'] === 'dateasc' && !empty($values['id_category']) && empty($values['id_subcategory'])) {

                    $result = $this->countProduct(null, ' WHERE id_category = :id_category ', null, intval($values['id_category']), null);
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->priceAsc(null, ' WHERE id_category = :id_category ORDER BY date_product ASC LIMIT :premier, :parpage ', null, null, intval($values['id_category']), null, $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if ($values['typeFiltre'] === 'dateasc' && !empty($values['id_subcategory']) && empty($values['id_category'])) {

                    $result = $this->countProduct(null, null, ' WHERE id_subcategory = :id_subcategory ', null, intval($values['id_category']));
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->priceAsc(null, null, ' WHERE id_subcategory = :id_subcategory ORDER BY date_product ASC LIMIT :premier, :parpage ', null, null, intval($values['id_subcategory']), $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if($values['typeFiltre'] === 'dateasc' && empty($values['id_subcategory']) && empty($values['id_category'])){

                    $result = $this->countProduct(null, null, null, null, null);
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->priceAsc(null, null, null, ' LIMIT :premier, :parpage ', null, null, $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }

            //Filtrage par date décroissante: par categorie, sous-categorie, ou sur l'ensemble de la boutique

                if ($values['typeFiltre'] === 'datedesc') {

                    $result = $this->countProduct(' WHERE id_category = :id_category AND id_subcategory = :id_subcategory ', null, null, intval($values['id_category']), intval($values['id_subcategory']) );
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->priceAsc(' WHERE id_category = :id_category AND id_subcategory = :id_subcategory ORDER BY date_product DESC LIMIT :premier, :parpage ', null, null, null, intval($values['id_category']), intval($values['id_subcategory']), $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if ($values['typeFiltre'] === 'datedesc' && !empty($values['id_category']) && empty($values['id_subcategory'])) {

                    $result = $this->countProduct(null, ' WHERE id_category = :id_category ', null, intval($values['id_category']), null);
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->priceAsc(null, ' WHERE id_category = :id_category ORDER BY date_product DESC LIMIT :premier, :parpage ', null, null, intval($values['id_category']), null, $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if ($values['typeFiltre'] === 'datedesc' && !empty($values['id_subcategory']) && empty($values['id_category'])) {

                    $result = $this->countProduct(null, null, ' WHERE id_subcategory = :id_subcategory ', null, intval($values['id_category']));
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->priceAsc(null, null, ' WHERE id_subcategory = :id_subcategory ORDER BY date_product DESC LIMIT :premier, :parpage ', null, null, intval($values['id_subcategory']), $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if($values['typeFiltre'] === 'datedesc' && empty($values['id_subcategory']) && empty($values['id_category'])){

                    $result = $this->countProduct(null, null, null, null, null);
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->priceAsc(null, null, null, ' LIMIT :premier, :parpage ', null, null, $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }

            //Filtrage produit les mieux notés: par categorie, sous-categorie, ou sur l'ensemble de la boutique

                if ($values['typeFiltre'] === 'toprating') {

                    $result = $this->countProduct(' WHERE id_category = :id_category AND id_subcategory = :id_subcategory ', null, null, intval($values['id_category']), intval($values['id_subcategory']) );
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->getProductTopRating(' WHERE id_category = :id_category AND id_subcategory = :id_subcategory GROUP BY product.id_product DESC LIMIT :premier, :parpage ', null, null, null, intval($values['id_category']), intval($values['id_subcategory']), $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if ($values['typeFiltre'] === 'toprating' && !empty($values['id_category']) && empty($values['id_subcategory'])) {

                    $result = $this->countProduct(null, ' WHERE id_category = :id_category ', null, intval($values['id_category']), null);
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->getProductTopRating(null, ' WHERE id_category = :id_category GROUP BY product.id_product DESC LIMIT :premier, :parpage ', null, null, intval($values['id_category']), null, $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if ($values['typeFiltre'] === 'toprating' && !empty($values['id_subcategory']) && empty($values['id_category'])) {

                    $result = $this->countProduct(null, null, ' WHERE id_subcategory = :id_subcategory ', null, intval($values['id_category']));
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->getProductTopRating(null, null, ' WHERE id_subcategory = :id_subcategory GROUP BY product.id_product DESC ', null,  null, intval($values['id_subcategory']), $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if($values['typeFiltre'] === 'toprating' && empty($values['id_subcategory']) && empty($values['id_category'])){

                    $result = $this->countProduct(null, null, null, null, null);
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->priceAsc(null, null, null, ' LIMIT :premier, :parpage ', null, null, $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }

                //Filtrage par rapport aux plus de ventes: avec categories, sous-categories, et sur toute la boutique en général

                if ($values['typeFiltre'] === 'topsail') {

                    $result = $this->countProduct(' WHERE id_category = :id_category AND id_subcategory = :id_subcategory ', null, null, intval($values['id_category']), intval($values['id_subcategory']) );
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->getTopProduct(' WHERE id_category = :id_category AND id_subcategory = :id_subcategory ORDER BY quantity DESC LIMIT :premier, :parpage ', null, null, null, intval($values['id_category']), intval($values['id_subcategory']), $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if ($values['typeFiltre'] === 'topsail' && !empty($values['id_category']) && empty($values['id_subcategory'])) {

                    $result = $this->countProduct(null, ' WHERE id_category = :id_category ', null, intval($values['id_category']), null);
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->getTopProduct(null, ' WHERE id_category = :id_category ORDER BY quantity DESC LIMIT :premier, :parPage ', null, null, intval($values['id_category']), null, $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if ($values['typeFiltre'] === 'topsail' && !empty($values['id_subcategory']) && empty($values['id_category'])) {

                    $result = $this->countProduct(null, null, ' WHERE id_subcategory = :id_subcategory ', null, intval($values['id_category']));
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->getTopProduct(null, null, ' WHERE id_subcategory = :id_subcategory ORDER BY quantity DESC LIMIT :premier, :parpage ', null, null, intval($values['id_subcategory']), $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
                if($values['typeFiltre'] === 'topsail' && empty($values['id_subcategory']) && empty($values['id_category'])){

                    $result = $this->countProduct(null, null, null, null, null);
                    $nbProduct = (int) $result['nb_product'];
                    $pages = ceil($nbProduct / $parPage);

                    $asc = $this->getTopProduct(null, null, null, ' LIMIT :premier, :parpage', null, null, $premier, $parPage);

                    foreach ($asc as $key => $value) {
                        $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                    }
                }
        }

        // Permet d'afficher les produits par rapport à la categorie et la sous-categorie, sans filtre

            if (empty($values['typeFiltre']) && empty($values['id_subcategory']) && !empty($values['id_category'])) {

                $result = $this->countProduct(' WHERE id_category = :id_category AND id_subcategory = :id_subcategory ', null, null, intval($values['id_category']), intval($values['id_subcategory']) );
                $nbProduct = (int) $result['nb_product'];
                $pages = ceil($nbProduct / $parPage);

                $asc = $this->getProductWithoutFilter(' WHERE id_category = :id_category LIMIT :premier, :parpage', intval($values['id_category']), null, null, null, $premier, $parPage);

                foreach ($asc as $key => $value) {
                    $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                }
            }

            if (empty($value['typeFiltre']) && !empty($values['id_subcategory']) && empty($values['id_category'])) {

                $result = $this->countProduct(null, null, ' WHERE id_subcategory = :id_subcategory ', null, intval($values['id_category']));
                $nbProduct = (int) $result['nb_product'];
                $pages = ceil($nbProduct / $parPage);

                $asc = $this->getProductWithoutFilter(null, null, ' WHERE id_subcategory = :id_subcategory LIMIT :premier, :parpage', null, intval($values['id_subcategory']), $premier, $parPage);

                foreach ($asc as $key => $value) {
                    $this->modelCardProductShop($value['id_product'], $value['img_product'], $value['name'], $value['price']);
                }
            }
        return $pages;
    }

    public function showResultSearchBar (){

        $controlSearch = new \app\controllers\Controllerheader();
        $tableSearch = $controlSearch->getSearchBar();

        foreach($tableSearch as $key => $values){

            $this->modelCardProductShop($values['id_product'], $values['img_product'], $values['name'], $values['price']);
        }

    }






}