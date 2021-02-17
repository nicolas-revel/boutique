<?php

namespace app\models;

class Modelaccueil extends model
{



    public function getTopProduct (): array
    {
        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT product.id_product, price, img_product, name, id_category, order_meta.id_order_meta, order_meta.id_product, order_meta.quantity FROM product INNER JOIN order_meta ON order_meta.id_product = product.id_product ORDER BY quantity DESC LIMIT 4");
        $req->execute();
        $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }


}