<?php


namespace app\Controllers;


class Controllerpanier extends \app\models\Modelpanier
{

    public function modifQuantity()
    {

        if (isset($_POST['panier']['quantity'])) {
            foreach ($_SESSION['panier'] as $product_id => $quantity) {
                if (isset($_POST['panier']['quantity'][$product_id]))
                    $_SESSION['panier'][$product_id] = $_POST['panier']['quantity'][$product_id];
            }
        }

    }

    public function add($id_product)
    {
        if (isset($_SESSION['panier'][$id_product])) {
            $_SESSION['panier'][$id_product]++;
        } else {
            $_SESSION['panier'][$id_product] = 1;
        }
    }


    public function delProductId($id_product)
    {
        unset($_SESSION['panier'][$id_product]);
    }

    public function totalPrice()
    {
        $total = 0;

        $ids = array_keys($_SESSION['panier']);
        if (empty($ids)) {
            $products = array();
        } else {
            $products = $this->getProductById($ids);
        }
        foreach ($products as $product) {
            $total += ($product->price * 1.196) * $_SESSION['panier'][$product->id_product];
        }
        return $total;
    }

    public function count()
    {
        return array_sum($_SESSION['panier']);
    }


    public function addAdressPanier()
    {

        if (!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false) {
            if (isset($_SESSION['user']) && !empty($_SESSION['user']->getId_user())) {

                if (!isset($_SESSION['adress'])) {
                    $_SESSION['adress'] = array();
                }

                if (isset($_POST['choose_adress'])) {
                    $adressPost = $_POST['choose_adress'];
                    $_SESSION['adress'] = $adressPost;
                }
            }
        }
    }

    public function getTotalPriceByProduct ($price, $product) {

        if(!isset($_SESSION['totalPriceByProduct'])){
            $_SESSION['totalPriceByProduct'] = array();
        }
        if(isset($_SESSION['panier'])){
                $_SESSION['totalPriceByProduct'] = number_format($price * intval($_SESSION['panier'][$product]), 2, ',', ' ');
                echo $_SESSION['totalPriceByProduct'];
        }
    }

    public function addExpeditionType()
    {
        if (!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false) {
            if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
                if (isset($_SESSION['user']) && !empty($_SESSION['user']->getId_user())) {

                    if (!isset($_SESSION['fraisLivraison'])) {
                        $_SESSION['fraisLivraison'] = array();
                    }

                    if (!isset($_SESSION['totalCommand'])) {
                        $_SESSION['totalCommand'] = array();
                    }

                    if (isset($_POST['prioritaire'])) {
                        $prioritaire = $_POST['prioritaire'];
                        $_SESSION['fraisLivraison'] = floatval($prioritaire);

                        $_SESSION['totalCommand'] = floatval(number_format($this->totalPrice() + 2, 2, ',', ' ')) + floatval($_SESSION['fraisLivraison']);

                    } elseif (isset($_POST['colissimo'])) {
                        $colissimo = $_POST['colissimo'];
                        $_SESSION['fraisLivraison'] = floatval($colissimo);

                        $_SESSION['totalCommand'] = floatval(number_format($this->totalPrice() + 2, 2, ',', ' ')) + floatval($_SESSION['fraisLivraison']);

                    } else {
                        $shop = $_POST['magasin'];
                        $_SESSION['fraisLivraison'] = floatval($shop);

                        $_SESSION['totalCommand'] = floatval(number_format($this->totalPrice() + 2, 2, ',', ' ')) + floatval($_SESSION['fraisLivraison']);

                    }
                }
            }
        }
    }

    public function insertShipping ($totalPrice) {

            if (isset($_SESSION['panier']) && !empty($_SESSION['panier']) && isset($_POST['payment'])) {
                if (isset($_SESSION['user']) && !empty($_SESSION['user']->getId_user())) {

                    $contprofil = new \app\controllers\controllerprofil();
                    $user_adresses = $contprofil->getAdressById_user($_SESSION['user']->getId_user());

                    if (gettype($user_adresses) === 'array') {
                        foreach ($user_adresses as $adress) {

                            if ($_SESSION['adress'] == $adress->getTitle()) {
                                $this->addShippingBdd($_SESSION['user']->getId_user(), $adress->getId_adress(), floatval($_SESSION['totalCommand']), 1);
                            }
                        }
                    }

                    $order = $this->getOrderBdd();
                    $ids = array_keys($_SESSION['panier']);

                    if (empty($ids)) {
                        $products = array();
                    } else {
                        $products = $this->getProductById($ids);
                    }

                    foreach ($products as $product) {
                        foreach ($order as $k => $v) {
                            $this->addOrderMetaBdd($v['id_order'], $product->id_product, $_SESSION['panier'][$product->id_product], $totalPrice);
                        }
                    }

                    $getStock = $this->selectStocksBdd();
                    $getquantity = $this->selectOrderMetaBdd();

                    foreach ($getStock as $key => $value) {
                        foreach ($getquantity as $keykey => $values) {
                            $stock = $value['stocks'] - $values['quantity'];
                            $this->updateStockAfterShipping(intval($stock), intval($values['id_product']));
                        }

                    }
                }
            }
            $this->preparePaiement();

    }

    /**
     * Fonction de vérouillage du panier pendant le paiement
     */
    public function preparePaiement()
    {
        $_SESSION['panier']['verrouille'] = true;
    }

    /**
     * Méthode enregistrement la commande en bdd et suppresion du panier
     */
    public function paiementAccepte()
    {
        unset($_SESSION['panier']);
    }
}








