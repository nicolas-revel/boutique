<?php


namespace app\Controllers;


class Controllerpanier
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

    public function deleteFormProduct($id_product)
    {
        if (!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false) {
            if (isset($_POST['delete']) && empty($_POST['quantity'])) {

                $this->deleteProductPanier($id_product);
                Header('Location: panier.php');
            }
        }
    }

    /**
     * Méthode comptage du prix total, ou d'un produit en particulier
     * @return float|int
     */
    public function countPricePanier (){

        $price = 0;

        $nbProduct = count($_SESSION['panier']['id_product']);

        if (!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false) {
            for ($i = 0; $i < $nbProduct; $i++) {

                $price += $_SESSION['panier']['quantity'][$i] * $_SESSION['panier']['price'][$i];
            }
        }

        return $price;
    }

    /**
     * Méthode modifier la quantity d'un produit dans le panier
     * @param $id_product
     * @param $quantity
     * @return bool
     */
    public function modifQuantityPanier($id_product, $quantity){

    $modif = false;

        if (!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false) {
            if ($this->countProduct($id_product) != false && $quantity != $this->countProduct($id_product)) {
                /* On compte le nombre d'articles différents dans le panier */
                $nbProduct = count($_SESSION['panier']['id_product']);
                /* On parcoure le tableau de session pour modifier l'article précis. */
                for ($i = 0; $i < $nbProduct; $i++) {
                    if ($id_product == $_SESSION['panier']['id_product']) {
                        $_SESSION['panier']['quantity'] = $quantity;
                        $modif = true;
                    }
                }
            } else {

                if ($this->countProduct($id_product) != false) {
                    $modif = "absent";
                }
                if ($quantity != $this->countProduct($id_product)) {
                    $modif = "qte_ok";
                }
            }
        }
    return $modif;
    }

    /**
     * Méthode pour vider le panier
     * @return bool
     */
    public function getEmptyPanier(){


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


    /**
     * Méthode vérifie le numbre d'article dans le panier
     * @param $id_product
     * @return false|mixed
     */
    public function countProduct($id_product){

        $number = false;

        $nbProduct = count($_SESSION['panier']['id_product']);

        if (!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false) {
            for ($i = 0; $i < $nbProduct; $i++) {
                if ($_SESSION['panier']['id_product'][$i] == $id_product) {
                    $number = $_SESSION['panier']['quantity'][$i];
                }
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
}