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
    public function countPricePanier()
    {

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

}