<?php


namespace app\Models;


class Modelpanier extends \app\models\model
{

    public function __construct(){
        if(!isset($_SESSION)){
            session_start();
        }
        if(!isset($_SESSION['panier'])){
            $_SESSION['panier'] = array();
        }
    }


    public function getProductIdBdd (){

        $bdd = $this->getBdd();
        $req = $bdd->prepare('SELECT id_product FROM product WHERE id_product = :id', $data = array('id' => $_GET['id']));
        $req->execute($data);
        return $req->fetchAll(\PDO::FETCH_OBJ);
    }



    public function getProductById ($ids) {

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
    public function addShippingBdd (int $id_user, int $id_adress, float $total_amount, int $id_status): void{

        $bdd = $this->getBdd();

        $req = $bdd->prepare("INSERT INTO ordershipping (date_order, id_user, id_adress, total_amount, id_status) VALUES (NOW(), :id_user, :id_adress, :total_amount, :id_status)");
        $req->bindValue(':id_user', $id_user);
        $req->bindValue('id_adress', $id_adress);
        $req->bindValue(':total_amount', $total_amount);
        $req->bindValue('id_status', $id_status);
        $req->execute();
    }

    public function addOrderMetaBdd (int $id_order, int $id_product, int $quantity, float $amount) {

        $bdd = $this->getBdd();

        $req = $bdd->prepare("INSERT INTO order_meta (id_order, id_product, quantity, amount) VALUES (:id_order, :id_product, :quantity, :amount)");
        $req->bindValue(':id_order', $id_order);
        $req->bindValue(':id_product', $id_product);
        $req->bindValue(':quantity', $quantity);
        $req->bindValue(':amount', $amount);
        $req->execute();

    }

    public function selectOrderMetaBdd (){

        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT * FROM order_meta");
        $req->execute();
        $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function getOrderBdd (){

        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT id_order, date_order, id_user, id_adress, total_amount, id_status FROM ordershipping");
        $req->execute();
        $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function selectCommandUser (int $id_user){

        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT ordershipping.id_order, ordershipping.date_order, ordershipping.id_adress, ordershipping.total_amount, ordershipping.id_user, order_meta.id_order, order_meta.quantity, order_meta.id_product, adresses.id_adress, adresses.title, adresses.country, adresses.town, adresses.postal_code, adresses.street, adresses.infos, adresses.number, users.firstname, users.lastname, users.id_user FROM ordershipping INNER JOIN order_meta ON ordershipping.id_order = order_meta.id_order INNER JOIN adresses ON ordershipping.id_adress = adresses.id_adress INNER JOIN users ON users.id_user = ordershipping.id_user  WHERE ordershipping.id_user = :id_user");
        $req->bindValue(':id_user', $id_user);
        $req->execute();
        $result =$req->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

}