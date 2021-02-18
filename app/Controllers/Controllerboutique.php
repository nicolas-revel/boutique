<?php

namespace app\controllers;

class Controllerboutique extends \app\models\Modelboutique
{
    /**
     * Méthode qui permet de compter tous les articles présents dans la base de donnée
     * @return int
     */
    public function nbrProduct() {

        $result = $this->countProduct(null, null, null, null, null);
        $nbProduct = (int) $result['nb_product'];

        return $nbProduct;
    }

    public function getFiltersForm ()
    {
        if (isset($_POST['chooseCat']) || ($_POST['chooseTypeFilter']) || ($_POST['chooseSubCat'])) {

            $_SESSION['filter'] = [['id_category' => $_POST['chooseCat'], 'typeFiltre' => $_POST['chooseTypeFilter'], 'id_subcategory' => $_POST['chooseSubCat']]];
            header('Location: boutique.php?filter=product');

        }
    }


}
