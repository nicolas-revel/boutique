<?php

namespace Views\components;

require'../vendor/autoload.php';

class viewHeader extends \app\controllers\Controllerheader
{
    /**
     * Méthode qui permet d'afficher les categories et ses sous-categories dans le dropdown (Header)
     */
    public function showNameCategorie()
    {
        $modelHeader = new \app\models\Modelheader();
        $table = $modelHeader->allCategory();
        $subCat = $this->allSubCategory();

        foreach ($table as $key => $value) {

            echo "<h3 id='titleDropdown'><a href='boutique.php?categorie=".$value['id_category']."'>".$value['category_name']."</a></h3>";

            foreach ($subCat as $keySub => $valueSub) {

                if($value['id_category'] === $valueSub['id_category']) {

                    echo "<a id='subCatText' href='boutique.php?subcategorie=".$valueSub['id_subcategory']."'>".$valueSub['subcategory_name']."</a>";
                }
            }
        }
    }
}
