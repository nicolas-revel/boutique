<?php


namespace app\views\components;

require'../vendor/autoload.php';

class viewProduct extends \app\controllers\Controllerproduit
{

    /**
     * Méthode qui permet d'afficher l'image du produit
     */
    public function showImageProduct()
    {
        $tableProduct = $this->getOneProduct();

        foreach($tableProduct as $key => $value){
            echo " <div id='imageProduct'>
                        <img id='pictureOneProduct' alt='Photo du produit' src='../images/imageboutique/".$value['img_product']."'>
                   </div>";
        }
    }

    public function showInfosProduct()
    {
        $tableProduct = $this->getOneProduct();

        foreach($tableProduct as $key => $value){

            $date = strftime('%d-%m-%Y', strtotime($value['date_product']));

            echo " <div id='cardInfosProduct'>
                       <h6>".$value['name']."</h6>
                       <small>Ajouter le : $date</small><br>
                       <small>Il reste (".$value['stocks']." exemplaires).</small>
                       <p>".$value['price']." €</p>
                       <p>".$value['description']."</p>
                   </div>";
        }
    }

    public function showCommentProduct()
    {
        $stars = new \app\views\components\viewAccueil();
        $tableComment = $this->getCommentProduct();

        foreach($tableComment as $key => $value){

            $dateFr = strftime('%d-%m-%Y', strtotime($value['date_comment']));

            echo "<div id='cardLastComment'>
                       <p class='chip'>Ecrit par : ".$value['lastname']." le $dateFr</p>
                           ".$stars->ratingStarsGrey($value['rating'])."
                            ".$stars->ratingStarsOrange($value['rating'])."
                                <h5 id='titleProductComment'>".$value['name']."</h5>
                                    <p id='contentComment'>".$value['content']."</p>
                                       </div>";
        }
    }
}