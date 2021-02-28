<?php


namespace app\Controllers;

require'../vendor/autoload.php';

class Controllerproduit extends \app\models\Modelproduit
{

    public function getOneProduct()
    {
        if (isset($_GET['product'])) {
            $id_product = $_GET['product'];
            $product = $this->getOneProductBdd(intval($id_product));
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
        if (empty($_POST['commentProduct'])){
            throw new \Exception("* Merci de remplir les champs du formulaire.");
        }

        try {
            $comment = htmlspecialchars(trim($_POST['commentProduct']));
            if (isset($_GET['product']) && isset($_GET['stars'])) {
                $id_product = $_GET['product'];
                $note = $_GET['stars'];
                $add = $this->addCommentBdd($id_user, $id_product, $comment, $note);
            }
            return $add;
        } catch (\Exception $e) {
            return $e;
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



