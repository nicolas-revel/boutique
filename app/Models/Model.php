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

        $req = $bdd->prepare("SELECT id_category, category_name, img_category FROM category");
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

    public function getCommentBddByProduct ($id_product) {

        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT id_comment, comment.id_user, comment.id_product, content, date_comment, rating, user.lastname, user.id_user, product.id_product, product.name FROM comment INNER JOIN user ON comment.id_user = user.id_user INNER JOIN product ON comment.id_product = product.id_product WHERE comment.id_product = :id_product");
        $req->bindValue(':id_product', $id_product, \PDO::PARAM_INT);
        $req->execute();
        $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function getAllCommentBdd () {

        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT id_comment, comment.id_user, comment.id_product, date_comment, content, rating, user.lastname, user.id_user, product.id_product, product.name FROM comment INNER JOIN user ON comment.id_user = user.id_user INNER JOIN product ON comment.id_product = product.id_product ORDER BY date_comment DESC LIMIT 3");
        $req->execute();
        $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function getTopProduct (?string $withCatAndSubCat, ?string $withCat, ?string $withSubCat, ?string $all, ?int $id_category, ?int $id_subcategory, $premier, $parPage ): array
    {
        //SELECT product.id_product, price, img_product, name, id_category, order_meta.id_order_meta, order_meta.id_product, order_meta.quantity FROM product INNER JOIN order_meta ON order_meta.id_product = product.id_product WHERE id_category = 1 AND id_subcategory = 1 ORDER BY quantity DESC LIMIT 4
        $bdd = $this->getBdd();
        $sql = "SELECT product.id_product, price, img_product, name, id_category, order_meta.id_order_meta, order_meta.id_product, order_meta.quantity FROM product INNER JOIN order_meta ON order_meta.id_product = product.id_product";

        if($withCatAndSubCat){
            $sql .= $withCatAndSubCat;
            $req = $bdd->prepare($sql);
            $req->bindValue(':id_category', $id_category, \PDO::PARAM_INT);
            $req->bindValue(':id_subcategory', $id_subcategory, \PDO::PARAM_INT);
            $req->bindValue(':premier', $premier, \PDO::PARAM_INT);
            $req->bindValue(':parpage', $parPage, \PDO::PARAM_INT);
            $req->execute();
            $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        } elseif($withCat){
            $sql .= $withCat;
            $req = $bdd->prepare($sql);
            $req->bindValue(':id_category', $id_category, \PDO::PARAM_INT);
            $req->bindValue(':premier', $premier, \PDO::PARAM_INT);
            $req->bindValue(':parpage', $parPage, \PDO::PARAM_INT);
            $req->execute();
            $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        }elseif ($withSubCat){
            $sql .= $withSubCat;
            $req = $bdd->prepare($sql);
            $req->bindValue(':id_subcategory', $id_subcategory, \PDO::PARAM_INT);
            $req->bindValue(':premier', $premier, \PDO::PARAM_INT);
            $req->bindValue(':parpage', $parPage, \PDO::PARAM_INT);
            $req->execute();
            $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        } elseif ($all) {
            $sql .= $all;
            $req = $bdd->prepare($sql);
            $req->bindValue(':premier', $premier, \PDO::PARAM_INT);
            $req->bindValue(':parpage', $parPage, \PDO::PARAM_INT);
            $req->execute();
            $result = $req->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $result;
    }

    public function getBdd () {

        return new \PDO('mysql:host=localhost;dbname=boutique;charset=utf8', 'root', '', [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ]);

    }
}