<?php


namespace app\Models;


class Modelpanier extends \app\models\model
{

    public function __construct(){

        if(!isset($_SESSION['panier'])){
            $_SESSION['panier'] = array();
        }
    }

    /**
     * Méthode qui récupère l'id des produits
     * @return array
     */
    public function getProductIdBdd (): array{

        $bdd = $this->getBdd();
        $req = $bdd->prepare('SELECT id_product FROM product WHERE id_product = :id', $data = array('id' => $_GET['id']));
        $req->execute($data);
        return $req->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Méthode qui récupère toutes les informations des produits passer en paramètres
     * @param $ids
     * @return array
     */
    public function getProductById ($ids): array {

        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT * FROM product WHERE id_product IN (".implode(',', $ids).")");
        $req->execute();
        return $req->fetchAll(\PDO::FETCH_OBJ);
    }


    /**
     * Méthode insertion de la commande en base de donnée
     * @param int $id_user
     * @param int $id_adress
     * @param float $total_amount
     * @param int $id_status
     */
    public function addShippingBdd (?int $id_user, ?int $id_guest, ?int $id_adress, float $total_amount, int $id_status){

        $bdd = $this->getBdd();

        $req = $bdd->prepare("INSERT INTO ordershipping (date_order, id_user, id_guest, id_adress, total_amount, id_status) VALUES (NOW(), :id_user, :id_guest, :id_adress, :total_amount, :id_status)");
        $req->bindValue(':id_user', $id_user);
        $req->bindValue(':id_guest', $id_guest);
        $req->bindValue('id_adress', $id_adress);
        $req->bindValue(':total_amount', $total_amount);
        $req->bindValue('id_status', $id_status);
        $req->execute();

        return true;
    }

    /**
     * Insertion des détails de la commande dans la table order_meta dans la base de donnée
     * @param int $id_order
     * @param int $id_product
     * @param int $quantity
     * @param float $amount
     */
    public function addOrderMetaBdd (int $id_order, int $id_product, int $quantity, float $amount) {

        $bdd = $this->getBdd();

        $req = $bdd->prepare("INSERT INTO order_meta (id_order, id_product, quantity, amount) VALUES (:id_order, :id_product, :quantity, :amount)");
        $req->bindValue(':id_order', $id_order);
        $req->bindValue(':id_product', $id_product);
        $req->bindValue(':quantity', $quantity);
        $req->bindValue(':amount', $amount);
        $req->execute();

    }

    /**
     * Récupére toutes les informations de la table order_meta
     * @return array
     */
    public function selectOrderMetaBdd (): array {

        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT * FROM order_meta");
        $req->execute();
        $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Récupère les informations des commandes
     * @return array
     */
    public function getOrderBdd (): array {

        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT id_order, date_order, id_user, id_adress, total_amount, id_status FROM ordershipping");
        $req->execute();
        $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Sélectionne toutes les informations de la commande par rapport à l'utilisateur
     * @param int $id_user
     * @param float $total_amount
     * @return array
     */
    public function selectCommandUser (int $id_user, float $total_amount): array{

        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT ordershipping.id_order, ordershipping.date_order, ordershipping.id_adress, ordershipping.total_amount, ordershipping.id_user, order_meta.id_order, adresses.id_adress, adresses.title, adresses.country, adresses.town, adresses.postal_code, adresses.street, adresses.infos, adresses.number, users.firstname, users.lastname, users.id_user FROM ordershipping INNER JOIN order_meta ON ordershipping.id_order = order_meta.id_order INNER JOIN adresses ON ordershipping.id_adress = adresses.id_adress INNER JOIN users ON users.id_user = ordershipping.id_user  WHERE ordershipping.id_user = :id_user AND ordershipping.total_amount LIKE :total_amount");
        $req->bindValue(':id_user', $id_user);
        $req->bindValue(':total_amount', $total_amount);
        $req->execute();
        $result =$req->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Sélectionne toutes les informations de la commande par rapport à un invité
     * @param int $id_guest
     * @return array
     */
    public function selectCommandGuest (int $id_guest): array{

        $bdd = $this->getBdd();
        $req = $bdd->prepare("SELECT ordershipping.id_order, ordershipping.date_order, ordershipping.id_adress, ordershipping.total_amount, ordershipping.id_guest, guests.id_guest, guests.guest_firstname, guests.guest_lastname, guests.title, guests.country, guests.town, guests.postal_code, guests.street, guests.infos, guests.number  FROM ordershipping INNER JOIN guests ON ordershipping.id_guest = guests.id_guest  WHERE ordershipping.id_guest = :id_guest");
        $req->bindValue(':id_guest', $id_guest);
        $req->execute();
        $result =$req->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Insertion d'un invité dans la base de donnée
     * @param string $guest_firstname
     * @param string $guest_lastname
     * @param string $guest_mail
     * @param string $title
     * @param string $country
     * @param string $town
     * @param string $postal_code
     * @param string $street
     * @param string $infos
     * @param int $number
     */
    public function addGuestBdd (string $guest_firstname, string $guest_lastname, string $guest_mail, string $title, string $country, string $town, string $postal_code, string $street, string $infos, int $number) {

        $bdd = $this->getBdd();

        $req = $bdd->prepare("INSERT INTO guests (guest_firstname, guest_lastname, guest_mail, title, country, town, postal_code, street, infos, number) VALUES (:guest_firstname, :guest_lastname, :guest_mail, :title, :country, :town, :postal_code, :street, :infos, :number)");
        $req->bindValue(':guest_firstname', $guest_firstname, \PDO::PARAM_STR);
        $req->bindValue(':guest_lastname', $guest_lastname, \PDO::PARAM_STR);
        $req->bindValue(':guest_mail', $guest_mail, \PDO::PARAM_STR);
        $req->bindValue(':title', $title, \PDO::PARAM_STR);
        $req->bindValue(':country', $country, \PDO::PARAM_STR);
        $req->bindValue(':town', $town, \PDO::PARAM_STR);
        $req->bindValue(':postal_code', $postal_code, \PDO::PARAM_STR);
        $req->bindValue(':street', $street, \PDO::PARAM_STR);
        $req->bindValue(':infos', $infos, \PDO::PARAM_STR);
        $req->bindValue(':number', $number, \PDO::PARAM_INT);
        $req->execute();

    }

    /**
     * Compte le nombre de commandes par rapport à un utilisateur ou un invité
     * @param int $id_user
     * @param string $total_amount
     * @param string $date_order
     * @return mixed
     */
    public function countCommandUser (int $id_user, string $total_amount, string $date_order) {
        
        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT COUNT(*) AS nbr FROM ordershipping WHERE (id_user = :id_user AND id_guest IS NULL) AND total_amount LIKE :total_amount AND date_order = :date_order");
        $req->execute([':id_user' => $id_user, ':total_amount' => $total_amount, ':date_order' => $date_order]);
        return($item = $req->fetch());
    }

    /**
     * Compte le nombre de commandes par rapport à un utilisateur ou un invité
     * @param int $id_guest
     * @param string $total_amount
     * @param string $date_order
     * @return mixed
     */
    public function countCommandGuest(int $id_guest, string $total_amount, string $date_order) {

        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT COUNT(*) AS nbr FROM ordershipping WHERE (id_user IS NULL AND id_guest = :id_guest) AND total_amount LIKE :total_amount AND date_order = :date_order");
        $req->execute([':id_guest' => $id_guest, ':total_amount' => $total_amount, ':date_order' => $date_order]);
        return($item = $req->fetch());
    }

    /**
     * Sélectionne les informations d'un produit en particulier de la table stocks
     * @return array
     */
    public function selectStocksBddById ($ids): array {

        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT id_stocks, id_product, stocks FROM stocks WHERE id_product IN (".implode(',', $ids).")");
        $req->execute();
        $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

}