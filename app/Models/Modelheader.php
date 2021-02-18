<?php

namespace app\models;

require 'Model.php';

class Modelheader extends \app\models\model
{

    public function searchBar ($query)
    {
        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT id_product, name, description, price, id_category, id_subcategory, date_product, img_product FROM product WHERE name LIKE '%".$query."%'");
        $req->execute();
        $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

}
