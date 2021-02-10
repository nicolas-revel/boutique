<?php

namespace app\controllers;

require'../../Models/Modelheader.php';

class Controllerheader extends \app\models\Modelheader
{

    public function showAllCategoryNavBar() {

        $all = $this->allCategory();

        foreach($all as $key => $value){
            $tab[$value['id_category']] = $value['category_name'];
        }

        return $tab;

    }

    public function showAllSubCategoryNavBar() {

        $all = $this->allSubCategory();

        foreach($all as $key => $value){
            $tab[$value['id_category']] = $value['subcategory_name'];
        }

        return $tab;

    }
}
