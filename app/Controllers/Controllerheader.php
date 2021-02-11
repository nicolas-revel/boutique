<?php

namespace app\controllers;

use http\Header;

require'../vendor/autoload.php';

class Controllerheader extends \app\models\Modelheader
{

    /**
     * Méthode de traitement de la SearchBar (Header)
     * @param $query
     */
    public function getSearchBar ($query)
    {
        if(!empty($_GET['search'])) {
            $query = htmlspecialchars(trim($_GET['search']));

            $goSearch = $this->searchBar($query);
            var_dump($goSearch);

            foreach($goSearch as $key => $value) {

                if($query == $value['name']) {
                    echo "COUCOU!";
                }
            }

        }
    }
}
