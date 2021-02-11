<?php

namespace app\views\components;

require'../vendor/autoload.php';

class viewAccueil extends \app\controllers\Controlleraccueil
{
    public function newProductView()
    {

        $modelAccueil = new \app\models\Modelaccueil();
        $tableNewProduct = $modelAccueil->getNewProduct();

        foreach($tableNewProduct as $key => $value){

            echo "<p>".$value['name']."</p>";
        }

    }

    public function TopProductView()
    {
        $modelAccueil = new \app\models\Modelaccueil();
        $tableTopProduct = $modelAccueil->getTopProduct();

        foreach($tableTopProduct as $key => $value){

            echo "<p>".$value['name']."</p>";
        }
    }
}
