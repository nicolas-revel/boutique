<?php

namespace app\controllers;


class Controlleraccueil extends \app\models\Modelaccueil
{
    //Rédirection sur la page index.
    public function index (){
        Header('Location: ../boutique/views/accueil.php');
    }

    /**
     * Permet de récupérer l'id de la catégorie "Terrarium" (Carousel)
     */
    public function getIdTerrarium (){

        $selectCategory = $this->allCategory();

        foreach($selectCategory as $k => $v){
            if($v['category_name'] == 'Terrariums'){
                $idCat = $v['id_category'];
                echo $idCat;
            }
        }

    }






}

