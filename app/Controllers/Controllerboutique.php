<?php

namespace app\controllers;

class Controllerboutique extends \app\models\Modelboutique
{
    /**
     * Méthode qui permet de compter tous les articles présents dans la base de donnée
     * @return int
     */
    public function nbrProduct(): int
    {
        $result = $this->countProduct(null, null, null, null, null);
        $nbProduct = (int)$result['nb_product'];

        return $nbProduct;
    }

    /**
     * Méthode traitement formulaire de filtrage
     * @return array[]|\Exception
     * @throws \Exception
     */
    public function getFiltersForm()
    {
        if (empty($_POST['chooseCat']) && empty($_POST['chooseTypeFilter']) && empty($_POST['chooseSubCat'])){
            throw new \Exception("* Merci de sélectionner au minimum une option.");
        }

        try {
            $_SESSION['filter'] = [['id_category' => $_POST['chooseCat'], 'typeFiltre' => $_POST['chooseTypeFilter'], 'id_subcategory' => $_POST['chooseSubCat']]];
            return $_SESSION['filter'];
        } catch (\Exception $e) {
            return $e;
        }
    }

}