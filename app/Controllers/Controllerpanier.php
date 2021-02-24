<?php


namespace app\Controllers;


class Controllerpanier extends \app\models\Modelpanier
{

    /**
     * Méthode suppresion d'une produit dans le panier.
     * @param $id_product
     * @param bool $reindex
     * @return bool|string
     */
    public function deleteProductPanier($id_product, $reindex = true)
    {
        $delete = false;
        $keyDelete = array_keys($_SESSION['panier']['id_product'], $id_product);

        if (!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false) {
            if (!empty ($keyDelete)) {
                foreach ($_SESSION['panier'] as $k => $v) {

                    foreach ($keyDelete as $v1) {

                        unset($_SESSION['panier'][$k][$v1]);
                    }

                    if ($reindex == true) {

                        $_SESSION['panier'][$k] = array_values($_SESSION['panier'][$k]);
                    }

                    $delete = true;
                }
            } else {
                $delete = "null";
            }
        }
        return $delete;
    }

    public function deleteFormProduct()
    {
        if (!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false) {

            $controlproduct = new \app\models\Modelproduit();
            $product = $this->showIdProduct();
            $tableProduct = $controlproduct->getOneProductBdd($product);

            if($product == $tableProduct[0]['id_product']) {

                if (isset($_POST['delete'])) {

                    $this->deleteProductPanier($product);
                    Header('Location: panier.php');
                }
            }
        }
    }

    /**
     * Méthode comptage du prix total, ou d'un produit en particulier
     * @return float|int
     */
    public function countPricePanier()
    {
        $price = 0;
        $nbProduct = count($_SESSION['panier']['id_product']);

            for ($i = 0; $i < $nbProduct; $i++) {
                $price += $_SESSION['panier']['quantity'][$i] * $_SESSION['panier']['price'][$i];
            }

        return $price;
    }

    public function countPricePanierWithTaxe (){

        $price = 0;
        $nbProduct = count($_SESSION['panier']['id_product']);

        for ($i = 0; $i < $nbProduct; $i++) {
            $price += $_SESSION['panier']['quantity'][$i] * $_SESSION['panier']['price'][$i];
        }

        return $price + $_SESSION['panier']['taxe'][0];
    }

    public function countPricePanierWithFraisLivraison (){

        $priceTotal = $this->countPricePanierWithTaxe();

        return $priceTotal + $_SESSION['panier']['fraisLivraison'][0];
    }

    /**
     * Méthode modifier la quantity d'un produit dans le panier
     * @param $product
     * @param $newQuantity
     */
    public function modifQuantityPanier($product, $newQuantity)
    {
        $count = $this->countProduct($product);

        if ($count > 0 && $newQuantity != $count) {

            $nbProduct = count($_SESSION['panier']['id_product']);

            for ($i = 0; $i < $nbProduct; $i++) {

                if (intval($product) == $_SESSION['panier']['id_product'][$i]) {
                    $_SESSION['panier']['quantity'][$i] = $newQuantity;
                    $msg = true;
                }
            }

        }
        return $msg;
    }

    public function modifPrice ($product, $newPrice){

        $count = $this->countProduct($product);

        if ($count > 0 && $newPrice != $count) {

            $nbProduct = count($_SESSION['panier']['id_product']);

            for ($i = 0; $i < $nbProduct; $i++) {

                if (intval($product) == $_SESSION['panier']['id_product'][$i]) {
                    $_SESSION['panier']['totalPrice'][$i] = $newPrice;
                }
            }

        }
    }

    /**
     * Méthode pour vider le panier
     * @return bool
     */
    public function getEmptyPanier()
    {
        $empty = false;

        if (!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false) {
            if (isset($_SESSION['panier'])) {

                unset($_SESSION['panier']);

                if (!isset($_SESSION['panier'])) {
                    $empty = true;
                }
            } else {
                $empty = "inexistant";
            }
        }
        return $empty;
    }

    /* Méthode vérifie le numbre d'article dans le panier
     * @param $id_product
     * @return mixed
     */
    public function countProduct($id_product)
    {
        $number = false;
        $nbProduct = count($_SESSION['panier']['id_product']);

        for ($i = 0; $i < $nbProduct; $i++) {
            if ($_SESSION['panier']['id_product'][$i] == $id_product) {
                $number = $_SESSION['panier']['quantity'][$i];
            }
        }

        return $number;
    }


    /**
     * Fonction de vérouillage du panier pendant le paiement
     */
    public function preparePaiement()
    {
        $_SESSION['panier']['verrouille'] = true;
        header("Location: URL_DU_SITE_DE_BANQUE");
    }

    /**
     * Méthode enregistrement la commande en bdd et suppresion du panier
     */
    public function paiementAccepte()
    {
        /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
        /*   Stockage du panier dans la BDD   */
        /* ajoutez ici votre code d'insertion */
        /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
        unset($_SESSION['panier']);
    }

    public function showIdProduct ()
    {
        if(isset($_SESSION['panier']) && !empty($_SESSION['panier'])){
            $table = $_SESSION['panier'];

            foreach($table as $key => $value){
                if(is_array($value)){
                    foreach($value as $keys => $values){
                        if($key == 'id_product'){
                            $product = $values;
                        }
                    }
                }
            }
        }
        return $product;
    }

    public function modifQuantityFromPanier ()
    {
        if (isset($_SESSION['panier']) && !empty($_POST['quantity'])) {

            $controlproduct = new \app\models\Modelproduit();
            $product = $this->showIdProduct();
            $tableProduct = $controlproduct->getOneProductBdd($product);

            if($product == $tableProduct[0]['id_product']) {

                $price = $tableProduct[0]['price'];
                $newQuantity = $_POST['quantity'];
                $modifQte = $this->modifQuantityPanier(intval($product), intval($newQuantity));

                if($modifQte){
                    $newPrice = $newQuantity * $price;
                    $this->modifPrice(intval($product), floatval($newPrice));
                }
            }

        }
    }

    public function addAdressPanier (){

        if(isset($_SESSION['panier']) && !empty($_SESSION['panier']) && isset($_POST['choose_adress'])){
            if(isset($_SESSION['user']) && !empty($_SESSION['user']->getId_user())){

                $adressPost = $_POST['choose_adress'];

                $contprofil = new \app\controllers\controllerprofil();
                $user_adresses = $contprofil->getAdressById_user($_SESSION['user']->getId_user());

                if (gettype($user_adresses) === 'array') {
                    foreach ($user_adresses as $adress) {

                        if($adressPost == $adress->getTitle()){
                            array_push($_SESSION['panier']['adress'], $adress->getTitle());
                        }

                    }
                }

            }

        }
    }

    public function addExpeditionType()
    {
        if(isset($_SESSION['panier']) && !empty($_SESSION['panier'])){
            if(isset($_SESSION['user']) && !empty($_SESSION['user']->getId_user())){

                if(isset($_POST['prioritaire'])){
                    $prioritaire = $_POST['prioritaire'];
                    array_push($_SESSION['panier']['fraisLivraison'], floatval($prioritaire));

                    $totalFrais = $this->countPricePanierWithFraisLivraison ();
                    array_push($_SESSION['panier']['totalFraisLivraison'], floatval($totalFrais));

                }elseif(isset($_POST['colissimo'])){
                    $colissimo = $_POST['colissimo'];
                    array_push($_SESSION['panier']['fraisLivraison'], floatval($colissimo));

                    $totalFrais = $this->countPricePanierWithFraisLivraison ();
                    array_push($_SESSION['panier']['totalFraisLivraison'], floatval($totalFrais));

                }else{
                    $shop = $_POST['magasin'];
                    array_push($_SESSION['panier']['fraisLivraison'], floatval($shop));

                    $totalFrais = $this->countPricePanierWithFraisLivraison ();
                    array_push($_SESSION['panier']['totalFraisLivraison'], floatval($totalFrais));
                }

            }

        }
    }

    public function insertShipping () {

        if(isset($_SESSION['panier']) && !empty($_SESSION['panier']) && isset($_POST['payment'])){
            if(isset($_SESSION['user']) && !empty($_SESSION['user']->getId_user())){

                $contprofil = new \app\controllers\controllerprofil();
                $user_adresses = $contprofil->getAdressById_user($_SESSION['user']->getId_user());

                if (gettype($user_adresses) === 'array') {
                    foreach ($user_adresses as $adress) {

                        if($_SESSION['panier']['adress'][0] == $adress->getTitle()){
                            $this->addShippingBdd($_SESSION['user']->getId_user(), $adress->getId_adress(), floatval($_SESSION['panier']['totalFraisLivraison'][0]), 1);
                        }
                    }
                }

                $order = $this->getOrderBdd ();
                $nbProduct = count($_SESSION['panier']['id_product']);

                foreach($order as $k => $v){
                    for($i = 0; $i < $nbProduct; $i++ ){
                        $this->addOrderMetaBdd($v['id_order'], $_SESSION['panier']['id_product'][$i], $_SESSION['panier']['quantity'][$i], $_SESSION['panier']['totalPrice'][$i]);
                    }
                }

                $getStock = $this->selectStocksBdd();
                $getquantity = $this->selectOrderMetaBdd ();

                foreach($getStock as $key => $value){
                    foreach($getquantity as $keykey => $values) {
                        $stock = $value['stocks'] - $values['quantity'];
                        $this->updateStockAfterShipping (intval($stock), intval($values['id_product']));
                    }

                }
            }
        }
    }
}