<?php

namespace Views\components;


class viewAccueil extends \app\controllers\Controlleraccueil
{

    /**
     * Méthode qui affiche les produits phares.
     */
    public function TopProductView()
    {
        $tableTopProduct = $this->getTopProduct(null, null, null, ' ORDER BY nbrProduct DESC LIMIT 4 ', null, null, null, null);

        foreach($tableTopProduct as $key => $value){

            echo " <div id='cardTopProduct'><a href='../views/produit.php?product=".$value['id_product']."'>
                        <div id='card-image'>
                            <img id='pictureProduct' alt='Photo du produit' src='../images/imageboutique/".$value['img_product']."'>
                        </div>
                        <div id='card-content'>
                            <h6>".$value['name']."</h6>
                            <p>" .number_format($value['price'], 2, ',', ' '). " €</p>
                        </div></a>
                   </div>";
        }
    }

    /**
     * Permet d'afficher les différentes catégories.
     */
    public function showCategoryWithPictures () {

        $selectCategory = $this->allCategory();

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

    /**
     * Permet d'afficher les derniers commentaires.
     */
    public function showLastComment (){

        $tableLastComment = $this->getAllCommentBdd();

        foreach($tableLastComment as $key => $value){

            $dateFr = strftime('%d-%m-%Y', strtotime($value['date_comment']));

            echo "<div id='cardLastComment'>
                       <p class='chip'>Ecrit par : ".$value['firstname']." le $dateFr</p>
                           ".$this->ratingStarsGrey($value['rating'])."
                            ".$this->ratingStarsOrange($value['rating'])."
                                <h5 id='titleProductComment'>".$value['name']."</h5>
                                    <p id='contentComment'>".$value['content']."</p>
                                       </div>";
                    
        }
    }

    /**
     * Permet d'afficher le nombre d'étoiles sélectionner lors de la notation
     * @param $value
     */
    public function ratingStarsOrange ($value){
        $i = 0;
        while ($i != $value) {
            echo "<div class='ratingAccueil'>
            <p>★</p>
            </div>";
            $i++;}

    }

    /**
     * Permet d'afficher le nombre d'étoiles non-sélectionnées lors de la notation.
     * @param $value
     */
    public function ratingStarsGrey ($value)
    {

        $i = 0;
        while ($i != (5 - $value)) {
            echo "<div class='ratingAccueilNone'>
            <p>★</p>
            </div>";
            $i++;}
    }

}
