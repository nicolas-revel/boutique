<?php

require'../../../app/Controllers/Controllerheader.php';

class viewHeader extends \app\controllers\Controllerheader
{
    public function showNameCategorie()
    {

        $modelHeader = new \app\models\Modelheader();
        $table = $modelHeader->allCategory();
        $subCat = $this->allSubCategory();

        foreach ($table as $key => $value) {

            echo "<a href='#'>".$value['category_name']."</a>";

            foreach ($subCat as $keySub => $valueSub) {

                if($value['id_category'] === $valueSub['id_category']) {

                    echo "<a href='#'>".$valueSub['subcategory_name']."</a>";
                }
            }

        }

    }


}
