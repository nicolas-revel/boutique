<?php

namespace app\controllers;

use http\Header;

require'../../Models/Modelheader.php';

class Controllerheader extends \app\models\Modelheader
{

    public function getSearchBar ($query)
    {
        if(!empty($_GET['search'])) {
            $query = htmlspecialchars(trim($_GET['search']));

            $goSearch = $this->searchBar($query);
            var_dump($goSearch);

            foreach($goSearch as $key => $value) {

                if($query == $value['name']) {
                    Header("Location: ../boutique.php");
                }
            }

        }
    }
}
