<?php

namespace app\models;

require 'Model.php';

class Modelheader extends \app\models\model
{

    public $elements = "id_category, category_name";
    public $table = "category";

    public function allSubCategory () {

        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT id_subcategory, id_category, subcategory_name FROM subcategory");
        $req->execute();
        $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function getBdd () {

            return new \PDO('mysql:host=localhost;dbname=boutique;charset=utf8', 'root', '', [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            ]);

    }
}
