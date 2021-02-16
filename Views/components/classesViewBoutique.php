<?php


namespace app\views\components;

require'../vendor/autoload.php';


class ViewBoutique extends \app\controllers\Controllerboutique
{

    public function newProductView()
    {

        $modelBoutique = new \app\models\Modelboutique();
        $tableNewProduct = $modelBoutique->getNewProduct();

        foreach($tableNewProduct as $key => $value){

            echo " <div id='cardNewProduct'><a href='../views/produit.php?product=".$value['id_product']."'>
                        <div id='card-image'>
                            <img id='pictureNewProduct' alt='Photo du produit' src='../images/imageboutique/".$value['img_product']."'>
                        </div>
                        <div id='content'>
                            <h6>".$value['name']." - <span id='newText'>NEW !</span></h6>
                            <p>".$value['price']." €</p>
                        </div></a>
                   </div>";
        }

    }

    public function TopProductView()
    {
        $modelAccueil = new \app\models\Modelboutique();
        $tableTopProduct = $modelAccueil->getNewProduct ();

        foreach($tableTopProduct as $key => $value){

            echo " <div id='cardTopProduct'><a href='../views/produit.php?product=".$value['id_product']."'>
                        <div id='card-image'>
                            <img id='pictureProduct' alt='Photo du produit' src='../images/imageboutique/".$value['img_product']."'>
                        </div>
                        <div id='card-content'>
                            <h6>".$value['name']."</h6>
                            <p>".$value['price']." €</p>
                        </div></a>
                   </div>";
        }
    }


}