<?php

namespace app\controllers;

class Controllerboutique extends \app\models\Modelboutique
{
    /**
     * Méthode qui permet de compter tous les articles présents dans la base de donnée
     * @return int
     */
    public function nbrProduct() {

        $result = $this->countProduct(null, null);
        $nbProduct = (int) $result['nb_product'];

        return $nbProduct;
    }

}
