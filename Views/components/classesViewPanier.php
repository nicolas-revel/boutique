<?php


namespace app\views\components;

require'../vendor/autoload.php';


class ViewPanier extends \app\controllers\Controllerpanier
{
    public function showPanier(){

        if(isset($_SESSION['panier']) && !empty($_SESSION['panier'])){

          $tablePanier = $_SESSION['panier'];

            foreach($tablePanier as $key => $valueOne){

                        echo " <div id='cardPanier'>
                        <div id='card-image'>
                            <img id='picturePanierProduct' alt='Photo du produit' src='../images/imageboutique/".$key['img_product']."'>
                        </div>
                        <div id='content'>
                            <h6>".$key['name']."</h6>
                            <p>".$key['quantity']."</p>
                            <p>".$key['price']."</p>
                        </div>
                        </div>";

                }
            }
        }

}