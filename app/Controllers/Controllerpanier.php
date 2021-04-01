<?php


namespace app\Controllers;


class Controllerpanier extends \app\models\Modelpanier
{

    /**
     * Permet de modifier la quantité d'un produit dans le panier
     * @throws \Exception
     */
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

    /**
     * Permet d'ajouter un produit dans la session panier
     * @param $id_product
     */
    public function add($id_product)
    {
        if (isset($_SESSION['panier'][$id_product])) {
            $_SESSION['panier'][$id_product];
            echo "<p id='msgProduct'>Le produit est déjà dans votre panier !</p>";
        } else {
            $_SESSION['panier'][$id_product] = 1;
        }
    }


    /**
     * Permet de supprimer un produit dans la panier
     * @param $id_product
     */
    public function delProductId($id_product)
    {
        unset($_SESSION['panier'][$id_product]);
    }

    /**
     * Permet de calculer le total du panier
     * @return float|int
     */
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

    /**
     * Permet de compter le nombre d'article dans le panier
     * @return float|int
     */
    public function count()
    {
        return array_sum($_SESSION['panier']);
    }

    /**
     * Permet d'ajouter une adresse dans une session
     */
    public function addAdressPanier()
    {
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

    /**
     * Permet d'avoir le prix total d'un produit par rapport à sa quantité
     * @param $price
     * @param $product
     */
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

    /**
     * Traitement du formulaire du type de livraison, qui sera stocké dans une session
     */
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

                if (isset($_POST['envoie'])) {

                    $_SESSION['fraisLivraison'] = floatval($_POST['envoie']);
                    $_SESSION['totalCommand'] = floatval($this->totalPrice() + 2) + floatval($_SESSION['fraisLivraison']);

                }
            }
        }
    }

    /**
     * Permet d'insérer la commande en base de donnée et de mettre ensuite à jour les stocks de chaque produit dans la base donnée
     */
    public function insertShipping()
    {
        if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
            if (isset($_SESSION['user']) && !empty($_SESSION['user']->getId_user())) {

                $contprofil = new \app\controllers\controllerprofil();
                $user_adresses = $contprofil->getAdressById_user($_SESSION['user']->getId_user());

                if (gettype($user_adresses) === 'array') {
                    foreach ($user_adresses as $adress) {

                        if ($_SESSION['adress'] == $adress->getTitle()) {
                            $date = date('Y-m-d');
                            $count = $this->countCommandUser($_SESSION['user']->getId_user(), strval($_SESSION['totalCommand']), $date);

                            //if($count['nbr'] == 0 ) {
                                $add = $this->addShippingBdd($_SESSION['user']->getId_user(), null, $adress->getId_adress(), floatval($_SESSION['totalCommand']), 1);

                                if($add == true){
                                    $infos = $this->getInfosOrder();
                                    $this->orderMeta($infos['id_order']);
                                }
                                $this->modifStocks();
                              //}
                        }
                    }
                }
            } else  {

                $guests = $this->getGuestBdd();

                foreach ($guests as $k => $v) {
                    if ($v->guest_firstname == $_SESSION['firstname'] && $v->guest_lastname == $_SESSION['lastname']) {

                        if ($_SESSION['adress'] == $v->title) {
                            $date = date('Y-m-d');
                            $count = $this->countCommandGuest($v->id_guest, strval($_SESSION['totalCommand']), $date);

                            if ($count['nbr'] == 0) {
                                $add = $this->addShippingBdd(null, $v->id_guest, null, floatval($_SESSION['totalCommand']), 1);
                                    if($add == true){
                                        $infos = $this->getInfosOrder();
                                        $this->orderMeta($infos['id_order']);
                                    }
                                    $this->modifStocks();
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Permet de modifier les stocks de chaque produit par rapport à sa quantité commandé à chaque commande
     */
    public function modifStocks () {

        $ids = array_keys($_SESSION['panier']);

        $getStock = $this->selectStocksBddById($ids);
        $getquantity = $this->selectOrderMetaBdd();

        foreach ($getStock as $key => $value) {
            foreach ($getquantity as $keykey => $values) {
                $stock = $value['stocks'] - $values['quantity'];
                $this->updateStockAfterShipping(intval($stock), intval($values['id_product']));
            }
        }
    }

    /**
     * Permet de récupérer les informations d'un commande nécéssaire à l'insertion dans la table order_meta
     * @return array
     */
    public function getInfosOrder (): array {

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
                $id = $v['id_order'];
                $tab = ['price' => $price, 'id_order' => $id, 'id_product' => $product->id_product];
            }
        }
        return $tab;
    }

    /**
     * Permet d'insérer dans la table order_meta
     * @param $id_order
     */
    public function orderMeta ($id_order) {

        $ids = array_keys($_SESSION['panier']);
        if (empty($ids)) {
            $products = array();
        } else {
            $products = $this->getProductById($ids);
        }
            foreach($products as $product){
                foreach($ids as $id){
                    if($id == $product->id_product) {
                        $this->addOrderMetaBdd($id_order, $product->id_product, $_SESSION['panier'][$product->id_product], floatval($product->price));
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

        if(!isset($_SESSION['user']) && empty($_SESSION['user'])){
            unset($_SESSION['firstname'], $_SESSION['lastname'], $_SESSION['adress_Name'], $_SESSION['email']);
        }
    }

    /**
     * Permet d'informer si le produit à bien été ajouté au panier
     */
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

    /**
     * Permet d'insérer l'adresse d'un invité ou une nouvelle adresse d'un utilisateur en base de donnée
     * @param int|null $id
     * @param $firstname
     * @param $lastname
     * @param $email
     * @param $title
     * @param $country
     * @param $town
     * @param $postal_code
     * @param $street
     * @param $infos
     * @param $number
     * @throws \Exception
     */
    public function insertAdressFromPanier (?int $id, ?string $firstname, $lastname, $email, $title, $country, $town, $postal_code, $street,$infos, $number) {

        if (empty($firstname) || empty($lastname) || empty($email) || empty($title) || empty($country) || empty($town) || empty($postal_code) || empty($street) || empty($number)) {
            throw new \Exception("Merci de bien remplir tous les champs obligatoires.");
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new \Exception("Merci de rentrer une adresse email valide");
        }

        if(!empty($firstname) && !empty($lastname) && !empty($email) && empty($_SESSION['user'])){

            if (!isset($_SESSION['firstname']) && !isset($_SESSION['lastname']) && !isset($_SESSION['email'])) {
                $_SESSION['adress'] = array();
                $_SESSION['firstname'] = array();
                $_SESSION['lastname'] = array();
                $_SESSION['email'] = array();
            }

            if (isset($_POST['add_new_adress'])) {
                $_SESSION['firstname'] = $firstname;
                $_SESSION['lastname'] = $lastname;
                $_SESSION['adress'] = $title;
                $_SESSION['email'] = $email;
                $this->addGuestBdd($_SESSION['firstname'], $_SESSION['lastname'] , $_SESSION['email'], $_SESSION['adress'], $country, $town, $postal_code, $street, $infos, $number);

            }
        }else {
            $profil = new \app\controllers\controllerprofil();
            $profil->insertAdress($id, null, $title, $country, $town, $postal_code, $street, $infos, $number);
        }

    }

    /**
     * Permet d'insérer l'adresse d'un invité ou une nouvelle adresse d'un utilisateur en base de donnée
     * @param int|null $id
     * @param $title
     * @param $country
     * @param $town
     * @param $postal_code
     * @param $street
     * @param $infos
     * @param $number
     * @throws \Exception
     */
    public function insertAdressFromPanierUser ($id, $title, $country, $town, $postal_code, $street,$infos, $number) {

        if (empty($title) || empty($country) || empty($town) || empty($postal_code) || empty($street) || empty($number)) {
            throw new \Exception("Merci de bien remplir tous les champs obligatoires.");
        }else {
            $profil = new \app\controllers\controllerprofil();
            $_SESSION['adress'] = $title;
            $profil->insertAdress($id, null, $title, $country, $town, $postal_code, $street, $infos, $number);
        }
    }

    /**
     * Instanciation de Stripe
     * @param $prix
     * @return \Stripe\PaymentIntent
     */
    public function stripeForm ($prix) {

        try {
            \Stripe\Stripe::setApiKey('sk_test_51INyY2KomI1Ouv8d9tPqAlc1IXZalzWEQCdC0ODd83e4Ow39THFZf3CjsjVZNbi7E8SwKEBVSuqu7Ly505UdBqry00RoWeYAQ1');

            $intent = \Stripe\PaymentIntent::create([
                'amount' => $prix*100,
                'currency' => 'eur'
            ]);
        } catch (\Exception $e) {
            $e->getMessage();
        }
         return $intent;
    }

}











