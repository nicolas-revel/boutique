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

    /**
     * Récupération des commentaires d'un produit par rapport à son id.
     * @param $id_product
     * @return array
     */
    public function getCommentBddByProduct ($id_product): array {

        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT id_comment, comment.id_user, comment.id_product, content, date_comment, rating, users.firstname, users.id_user, product.id_product, product.name FROM comment INNER JOIN users ON comment.id_user = users.id_user INNER JOIN product ON comment.id_product = product.id_product WHERE comment.id_product = :id_product ORDER BY date_comment DESC LIMIT 10");
        $req->bindValue(':id_product', $id_product, \PDO::PARAM_INT);
        $req->execute();
        $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Récupération de touts les commentaires, produit confondu en base de donnée
     * @return array
     */
    public function getAllCommentBdd () {

        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT id_comment, comment.id_user, comment.id_product, date_comment, content, rating, users.lastname, users.firstname, users.id_user, product.id_product, product.name FROM comment INNER JOIN users ON comment.id_user = users.id_user INNER JOIN product ON comment.id_product = product.id_product ORDER BY date_comment DESC LIMIT 3");
        $req->execute();
        $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Récupération des produits les plus vendu par rappot à la categorie, sous-categorie, les deux ou en général
     * @param string|null $withCatAndSubCat
     * @param string|null $withCat
     * @param string|null $withSubCat
     * @param string|null $all
     * @param int|null $id_category
     * @param int|null $id_subcategory
     * @param int|null $premier
     * @param int|null $parPage
     * @return array
     */
    public function getTopProduct (?string $withCatAndSubCat, ?string $withCat, ?string $withSubCat, ?string $all, ?int $id_category, ?int $id_subcategory, ?int $premier, ?int $parPage ): array
    {
        $bdd = $this->getBdd();
        $sql = "SELECT product.id_product, price, img_product, name, id_category FROM product INNER JOIN (SELECT id_product, COUNT(DISTINCT quantity) AS nbrProduct FROM order_meta GROUP BY id_product DESC) AS top ON top.id_product = product.id_product";


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

    /**
     * Méthode qui permet de modifier les stocks par rapport à une commande ou par rapport à une livraison
     * @param int $stocks
     * @param int $id_product
     */
    public function updateStockAfterShipping (int $stocks, int $id_product): void{

        $bdd = $this->getBdd();

        $req = $bdd->prepare("UPDATE stocks SET stocks = :stocks WHERE id_product = :id_product");
        $req->bindValue(':stocks', $stocks, \PDO::PARAM_INT);
        $req->bindValue(':id_product', $id_product, \PDO::PARAM_INT);
        $req->execute();

    }

    /**
     * Sélectionne tout les invité dans la base de donnée.
     * @return array
     */
    public function getGuestBdd (): array {

        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT * FROM guests");
        $req->execute();
        $result = $req->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    public function getBdd () {

        return new \PDO('mysql:host=localhost;dbname=boutique;charset=utf8', 'root', '', [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ]);

    }


}