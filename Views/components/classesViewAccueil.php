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

    public function showCategoryWithPictures () {

        $modelAccueil = new \app\models\Modelaccueil();
        $selectCategory = $modelAccueil->allCategory();

        foreach($selectCategory as $key => $value){

            echo "<div class='row' id='cardCategory'>
                    <div  class='col s12 xl12' id='flexCardCategory'><a href='../views/boutique.php?categorie=".$value['id_category']."'>
                        <div class='card blue-grey darken-1'>
                            <div id='cardCategory2' class='card-content white-text' style='background-image: url(../images/imagecategory/".$value['img_category']."); background-size: cover'>
                                <span id='titleCardCategory' class='card-title'>".$value['category_name']."</span>
                            </div>
                        </div></a>
                    </div>
                  </div>";
        }
    }

    public function showSubCategoryOptionSelect()
    {
        $tableSubCategory = $this->selectSubCategory();

        foreach ($tableSubCategory as $key => $value) {
            echo "<option value='$key'>$value</option>";
        }
    }
}
