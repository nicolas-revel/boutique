<?php

namespace app\models;

class Modelaccueil extends model
{

    /**
     * Méthode qui permet de sélectionner en BDD les trois derniers produits (Page Accueil et Page Boutique)
     * @return array
     */
    public function getNewProduct (): array
    {
       $bdd = $this->getBdd();

       $req = $bdd->prepare("SELECT * FROM product ORDER BY id_product DESC LIMIT 3");
       $req->execute();
       $result = $req->fetchAll(\PDO::FETCH_ASSOC);

       return $result;
    }

    public function getTopProduct (): array
    {
        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT product.id_product, name, order_meta.id_order_meta, order_meta.id_product, order_meta.quantity FROM product INNER JOIN order_meta ON order_meta.id_product = product.id_product ORDER BY quantity DESC LIMIT 4");
        $req->execute();
        $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function addCategoryBdd ($category_name, $img_category): void
    {
        $bdd = $this->getBdd();

        $req = $bdd->prepare("INSERT INTO category (category_name, img_category) VALUES (:category_name, :img_category)");
        $req->bindValue(':category_name', $category_name);
        $req->bindValue(':img_category', $img_category);
        $req->execute() or die(print_r($req->errorInfo()));

    }
}