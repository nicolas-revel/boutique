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

            echo "<h1>".$value['name']."</h1>";
        }

    }

    public function TopProductView()
    {
        $modelAccueil = new \app\models\Modelaccueil();
        $tableTopProduct = $modelAccueil->getTopProduct();

        foreach($tableTopProduct as $key => $value){

            echo "<h1>".$value['name']."</h1>";
        }
    }
}
