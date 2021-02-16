<?php

namespace app\models;

class Modeladmin extends model
{

    public function addProductBdd($name, $description, $price, $id_subcategory, $img_product): void
    {
        $bdd = $this->getBdd();

        $req = $bdd->prepare("INSERT INTO product (name, description, price, id_subcategory, date_product, img_product) VALUES (:name, :description, :price, :id_subcategory, NOW(), :img_product)");
        $req->bindValue(':name', $name);
        $req->bindValue(':description', $description);
        $req->bindValue(':price', $price);
        $req->bindValue(':id_subcategory', $id_subcategory);
        $req->bindValue(':img_product', $img_product);
        $req->execute() or die(print_r($req->errorInfo()));

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
