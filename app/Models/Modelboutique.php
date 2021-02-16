<?php

namespace app\models;

class Modelboutique extends model
{
    /**
     * Méthode qui permet de sélectionner en BDD les trois derniers produits (Page Accueil et Page Boutique)
     * @return array
     */
    public function getNewProduct (): array
    {
        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT * FROM product ORDER BY id_product DESC LIMIT 6");
        $req->execute();
        $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }
}