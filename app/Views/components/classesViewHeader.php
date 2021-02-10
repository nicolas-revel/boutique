<?php

require'../../../app/Controllers/Controllerheader.php';

class viewHeader extends \app\controllers\Controllerheader
{
    public function showNameCategorie()
    {
        $table = $this->showAllCategoryNavBar();


        foreach ($table as $key => $value) {
            $subTable = $this->showAllSubCategoryNavBar();

            foreach($subTable as $keySub => $valueSub){

                if($key == $keySub) {

                    echo "<li value='$key'><a href='articles.php?categorie=$key'>$value</a></li>
                            <li><a href='articles.php?categorie=$key'>$valueSub</a></li>";

                }
            }

        }
    }

}
