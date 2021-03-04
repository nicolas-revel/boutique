<?php


namespace app\Controllers;


class Controllerpanier extends \app\models\Modelpanier
{

    public function modifQuantity()
    {
        if (isset($_POST['panier']['quantity'])) {

            foreach ($_SESSION['panier'] as $product_id => $quantity) {
                if (isset($_POST['panier']['quantity'][$product_id])) {

                    $controlProduct = new \app\models\Modelproduit();
                    $tableProduct = $controlProduct->getOneProductBdd(intval($product_id));

                    foreach($tableProduct as $k => $v){
                        if($_POST['panier']['quantity'][$product_id] > $v['stocks']){
                            throw new \Exception("* La quantité demandé est supérieure à la quantité en stock");
                        }
                    }

                    $_SESSION['panier'][$product_id] = $_POST['panier']['quantity'][$product_id];
                    Header('Location: panier.php');

                }
            }
        }
    }

    public function add($id_product)
    {
        if (isset($_SESSION['panier'][$id_product])) {
            $_SESSION['panier'][$id_product];
            echo "<p id='msgProduct'>Le produit est déjà dans votre panier !</p>";
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
            $total += ($product->price) * $_SESSION['panier'][$product->id_product];
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

    public function getTotalPriceByProduct($price, $product)
    {
        if (!isset($_SESSION['totalPriceByProduct'])) {
            $_SESSION['totalPriceByProduct'] = array();
        }
        if (isset($_SESSION['panier'])) {
            $_SESSION['totalPriceByProduct'] = number_format($price * intval($_SESSION['panier'][$product]), 2, ',', ' ');
            echo $_SESSION['totalPriceByProduct'];
        }
    }

    public function addExpeditionType()
    {
        if (!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false) {
            if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {

                if (!isset($_SESSION['fraisLivraison'])) {
                    $_SESSION['fraisLivraison'] = array();
                }

                if (!isset($_SESSION['totalCommand'])) {
                    $_SESSION['totalCommand'] = array();
                }

                if (isset($_POST['prioritaire'])) {
                    $prioritaire = $_POST['prioritaire'];
                    $_SESSION['fraisLivraison'] = floatval($prioritaire);

                    $_SESSION['totalCommand'] = floatval($this->totalPrice() + 2) + floatval($_SESSION['fraisLivraison']);

                } elseif (isset($_POST['colissimo'])) {
                    $colissimo = $_POST['colissimo'];
                    $_SESSION['fraisLivraison'] = floatval($colissimo);

                    $_SESSION['totalCommand'] = floatval($this->totalPrice() + 2) + floatval($_SESSION['fraisLivraison']);

                } else {
                    $shop = $_POST['magasin'];
                    $_SESSION['fraisLivraison'] = floatval($shop);

                    $_SESSION['totalCommand'] = floatval($this->totalPrice() + 2) + floatval($_SESSION['fraisLivraison']);

                }
            }
        }
    }

    public function insertShipping()
    {
        if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
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
            }

            if(empty($_SESSION['user'])) {

                $guest = $this->getGuestBdd();

                foreach($guest as $k => $v)
                {
                    if($v->guest_firstname == $_SESSION['firstname'] && $v->guest_lastname == $_SESSION['lastname'])
                    {
                        $user_adresses = $this->getAdressById_guestDb(intval($v->id_guest));
                        var_dump($user_adresses);

                        if (gettype($user_adresses) === 'array') {
                            foreach ($user_adresses as $adress) {

                                if ($_SESSION['adress_Name'] == $adress['title']) {
                                    $this->addShippingBdd(null, $v->id_guest, $adress['id_adress'], floatval($_SESSION['totalCommand']), 1);
                                }
                            }
                        }
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
                        $price = $product->price * intval($_SESSION['panier'][$product->id_product]);
                        $this->addOrderMetaBdd($v['id_order'], $product->id_product, $_SESSION['panier'][$product->id_product], floatval($price));
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

    /**
     * Méthode enregistrement la commande en bdd et suppresion du panier
     */
    public function paiementAccepte()
    {
        unset($_SESSION['panier']);
        unset($_SESSION['adress']);
        unset($_SESSION['fraisLivraison']);
        unset($_SESSION['totalCommand']);
    }

    public function showAddPanier()
    {

        if (isset($_GET['id'])) {

            $product = $this->getProductIdBdd();

            if(!empty($product)){
                echo "<p class='flow-text' id='textAdd'>Le produit à bien été ajouté à votre panier.</p>";
                $this->add($product[0]->id_product);

            } else {
                echo "<p class='flow-text' id='textAdd'>Le produit est inexistant.</p>";
            }

        } elseif (empty($product) || empty($_GET['id']))
            echo "<p class='flow-text' id='textAdd'>Le produit est inexistant.</p>";
    }

    public function insertAdressFromPanier (?int $id, $firstname, $lastname, $email, $title, $country, $town, $postal_code, $street, $infos, $number) {

        if (empty($firstname) || empty($lastname) || empty($email) || empty($title) || empty($country) || empty($town) || empty($postal_code) || empty($street) || empty($number)) {
            throw new \Exception("Merci de bien remplir tous les champs obligatoires.");
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new \Exception("Merci de rentrer une adresse email valide");
        }

        if(!empty($firstname) && !empty($lastname) && !empty($email) && empty($_SESSION['user'])){

            if (!isset($_SESSION['firstname']) && !isset($_SESSION['lastname']) && !isset($_SESSION['email'])) {
                $_SESSION['adress_Name'] = array();
                $_SESSION['firstname'] = array();
                $_SESSION['lastname'] = array();
                $_SESSION['email'] = array();
            }

            if (isset($_POST['add_new_adress'])) {
                $_SESSION['firstname'] = $firstname;
                $_SESSION['lastname'] = $lastname;
                $_SESSION['adress_Name'] = $title;
                $_SESSION['email'] = $email;
                $this->addGuestBdd($_SESSION['firstname'], $_SESSION['lastname'] , $_SESSION['email']);

                $guest = $this->getGuestBdd();

                foreach($guest as $k => $v)
                {
                   if($v->guest_firstname == $_SESSION['firstname'] && $v->guest_lastname == $_SESSION['lastname'])
                   {
                       $profil = new \app\controllers\controllerprofil();
                       $profil->insertAdress(null, intval($v->id_guest), $title, $country, $town, $postal_code, $street, $infos, $number);
                   }
                }
            }
        }else {
            $profil = new \app\controllers\controllerprofil();
            $profil->insertAdress($id, null, $title, $country, $town, $postal_code, $street, $infos, $number);
        }




    }
}











