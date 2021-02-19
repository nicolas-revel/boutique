<?php


namespace app\Controllers;


use http\Header;

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

                        $_SESSION['panier']['id_product'] = [];
                        $_SESSION['panier']['name'] = [];
                        $_SESSION['panier']['price'] = [];
                        $_SESSION['panier']['img_product'] = [];
                        $_SESSION['panier']['quantity'] = [];
                        $_SESSION['panier']['id_user'] = [];


                    }

                    $verif = $this->verifProductPanier($product);

                    if (isset($_SESSION['panier']) && !$verif) {

                        array_push($_SESSION['panier']['id_product'], $product);
                        array_push($_SESSION['panier']['name'], $nameProduct);
                        array_push($_SESSION['panier']['price'], $price);
                        array_push($_SESSION['panier']['img_product'], $img_product);
                        array_push($_SESSION['panier']['quantity'], $quantity);
                        array_push($_SESSION['panier']['id_user'], $id_user);

                        Header("Location: panier.php");

                    } else {
                        $modif = new \app\controllers\Controllerpanier();
                        $modif->modifQuantityPanier($product, $quantity);
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



