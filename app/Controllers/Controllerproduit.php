<?php


namespace app\Controllers;

require'../vendor/autoload.php';

class Controllerproduit extends \app\models\Modelproduit
{

    public function getOneProduct()
    {

        if (isset($_GET['product'])) {
            $id_product = $_GET['product'];
            $product = $this->getOneProductBdd($id_product);
        }

        return $product;
    }

    public function getCommentProduct()
    {

        if (isset($_GET['product'])) {
            $id_product = $_GET['product'];
            $productComment = $this->getCommentBddByProduct($id_product);
        }
        return $productComment;
    }


    public function addComment($id_user)
    {

        if (!empty($_POST['commentProduct'])) {

            $comment = htmlspecialchars(trim($_POST['commentProduct']));

            if (isset($_GET['product']) && isset($_GET['stars'])) {

                $id_product = $_GET['product'];
                $note = $_GET['stars'];

                $this->addCommentBdd($id_user, $id_product, $comment, $note);
            }
        }
    }

    public function TraitmentFormPanier($id_user)
    {
        $tableProduct = $this->getOneProduct();

        if (!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false) {

            if (!empty($_POST['quantity']) && isset($_GET['product'])) {

                $quantity = $_POST['quantity'];
                $product = $_GET['product'];
                $price = $tableProduct[0]['price'];
                $nameProduct = $tableProduct[0]['name'];
                $img_product = $tableProduct[0]['img_product'];

                if ($quantity < $tableProduct[0]['stocks']) {

                    if (!isset($_SESSION['panier'])) {

                        $_SESSION['panier']['img_product'] = [];
                        $_SESSION['panier']['id_product'] = [];
                        $_SESSION['panier']['name'] = [];
                        $_SESSION['panier']['quantity'] = [];
                        $_SESSION['panier']['price'] = [];
                        $_SESSION['panier']['totalPrice'] = [];
                        $_SESSION['panier']['id_user'] = [];

                    }

                    $verif = $this->verifProductPanier($product);

                    if (isset($_SESSION['panier']) && $verif == false){

                        $priceTotal = $quantity * $price;

                        array_push($_SESSION['panier']['img_product'], $img_product);
                        array_push($_SESSION['panier']['id_product'], intval($product));
                        array_push($_SESSION['panier']['name'], $nameProduct);
                        array_push($_SESSION['panier']['quantity'], intval($quantity));
                        array_push($_SESSION['panier']['price'], floatval($price));
                        array_push($_SESSION['panier']['totalPrice'], floatval($priceTotal));
                        array_push($_SESSION['panier']['id_user'], intval($id_user));


                    }
                    if (isset($_SESSION['panier']) && $verif == true) {

                        $newQuantity = $_POST['quantity'];
                        $controlePanier = new \app\controllers\Controllerpanier();
                        $controlePanier->modifQuantityPanier(intval($product), intval($newQuantity));

                    }


                }
            }
        }

    }



    /**
     * Méthode qui vérifie la présence d'un article dans le panier
     * @param $id_product , produit à vérifier
     * @return bool
     */
    public function verifProductPanier($id_product): bool
    {
        $present = false;

        if (count($_SESSION['panier']['id_product']) > 0 && array_search($id_product, $_SESSION['panier']['id_product']) !== false) {
            $present = true;
        }

        return $present;
    }


}



