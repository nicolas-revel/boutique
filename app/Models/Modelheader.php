<?php

namespace app\models;


class Modelheader extends \app\models\model
{

    /**
     * Permet de sélectionner un produit par rapport à la recherche de l'utilisateur
     * @param $query
     * @return array
     */
    public function searchBar ($query): array
    {
        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT id_product, name, description, price, id_category, id_subcategory, date_product, img_product FROM product WHERE name LIKE '%".$query."%'");
        $req->execute();
        $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

}