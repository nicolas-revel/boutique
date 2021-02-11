<?php

namespace app\models;

class model
{

    /**
     * Méthode commune qui permet de récupérer tout les articles (Header/ Page accueil/ Page boutique)
     * @return array
     */
    public function allCategory (): array
    {
        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT id_category, category_name FROM category");
        $req->execute();
        $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $result;

    }

    /**
     * Méthode commune qui permet de récupérer toutes les sous-categories.
     * @return array
     */
    public function allSubCategory (): array
    {

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