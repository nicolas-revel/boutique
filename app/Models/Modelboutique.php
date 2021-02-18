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


    public function getAllProduct(?string $withLimit = '', ?int $premier, ?int $parPage){

        $bdd = $this->getBdd();
        $sql = "SELECT id_product, name, description, price, id_category, id_subcategory, date_product, img_product FROM product ORDER BY name ASC";

        if($withLimit){
            $sql .= $withLimit;
            $req = $bdd->prepare($sql);
            $req->bindValue(':premier', $premier, \PDO::PARAM_INT);
            $req->bindValue(':parpage', $parPage, \PDO::PARAM_INT);
            $req->execute();
            $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        } else {
            $sql;
            $req = $bdd->prepare($sql);
            $req->execute();
            $result = $req->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $result;
    }

    /**
     *  Méthode qui permet de compter le nombre de produit en général ou par rapport l'id de la catégorie
     * @param string|null $withCategoryAndSubCat
     * @param string|null $withCat
     * @param string|null $withSubCat
     * @param int|null $id_category
     * @param int|null $id_subcategory
     * @return array|mixed
     */
    public function countProduct(?string $withCategoryAndSubCat, ?string $withCat, ?string $withSubCat, ?int $id_category , ?int $id_subcategory)
    {
        $bdd = $this->getBdd();
        $sql = "SELECT COUNT(*) AS nb_product FROM product";

        if ($withCategoryAndSubCat) {

            $sql .= $withCategoryAndSubCat;
            $req = $bdd->prepare($sql);
            $req->bindValue(':id_category', $id_category, \PDO::PARAM_INT);
            $req->bindValue(':id_subcategory', $id_subcategory, \PDO::PARAM_INT);
            $req->execute();
            $result = $req->fetch();

        } elseif($withCat) {

            $sql .= $withCat;
            $req = $bdd->prepare($sql);
            $req->bindValue(':id_category', $id_category, \PDO::PARAM_INT);
            $req->execute();
            $result = $req->fetch();

        }elseif($withSubCat) {

            $sql .= $withSubCat;
            $req = $bdd->prepare($sql);
            $req->bindValue(':id_subcategory', $id_subcategory, \PDO::PARAM_INT);
            $req->execute();
            $result = $req->fetch();

        }else {
            $sql;
            $req = $bdd->prepare($sql);
            $req->execute();
            $result = $req->fetch();
        }

        return $result;
    }


    public function getProductTopRating (?string $withCatSubCat, ?string $withCat, ?string $withSubCat, ?string $all, ?int $id_category, ?int $id_subcategory, $premier, $parPage) {

        $bdd = $this->getBdd();
        $sql = "SELECT product.id_product, name, description, price, id_category, id_subcategory, date_product, img_product, comment.id_product, AVG(comment.rating) FROM product INNER JOIN comment ON comment.id_product = product.id_product";

        if($withCatSubCat){
            $sql .= $withCatSubCat;
            $req = $bdd->prepare($sql);
            $req->bindValue(':id_category', $id_category, \PDO::PARAM_INT);
            $req->bindValue(':id_subcategory', $id_subcategory, \PDO::PARAM_INT);
            $req->bindValue(':premier', $premier, \PDO::PARAM_INT);
            $req->bindValue(':parpage', $parPage, \PDO::PARAM_INT);
            $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        } elseif ($withCat) {
            $sql .= $withCat;
            $req = $bdd->prepare($sql);
            $req->bindValue(':id_category', $id_category, \PDO::PARAM_INT);
            $req->bindValue(':premier', $premier, \PDO::PARAM_INT);
            $req->bindValue(':parpage', $parPage, \PDO::PARAM_INT);
            $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        }elseif ($withSubCat){
            $sql .= $withCat;
            $req = $bdd->prepare($sql);
            $req->bindValue(':id_category', $id_category, \PDO::PARAM_INT);
            $req->bindValue(':premier', $premier, \PDO::PARAM_INT);
            $req->bindValue(':parpage', $parPage, \PDO::PARAM_INT);
            $result = $req->fetchAll(\PDO::FETCH_ASSOC);
        }

        elseif ($all) {
            $sql .= $all;
            $req = $bdd->prepare($sql);
            $req->bindValue(':premier', $premier, \PDO::PARAM_INT);
            $req->bindValue(':parpage', $parPage, \PDO::PARAM_INT);
            $req->execute();
            $result = $req->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $result;
    }

    public function priceAsc (?string $fullRequestWithCategoryAndSubcategory, ?string $fullRequestWithCategory, ?string $fullRequestWithSubCategory, ?string $all, ?int $id_category, ?int $id_subcategory, int $premier, int $parPage) {

        $bdd = $this->getBdd();
        $sql = "SELECT id_product, name, description, price, id_category, id_subcategory, date_product, img_product FROM product";

        if($fullRequestWithCategoryAndSubcategory){

            $sql .= $fullRequestWithCategoryAndSubcategory;
            $req = $bdd->prepare($sql);
            $req->bindValue(':id_category', $id_category, \PDO::PARAM_INT);
            $req->bindValue(':id_subcategory', $id_subcategory, \PDO::PARAM_INT);
            $req->bindValue(':premier', $premier, \PDO::PARAM_INT);
            $req->bindValue(':parpage', $parPage, \PDO::PARAM_INT);
            $req->execute();
            $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        } elseif ($fullRequestWithCategory) {

            $sql .= $fullRequestWithCategory;
            $req = $bdd->prepare($sql);
            $req->bindValue(':id_category', $id_category, \PDO::PARAM_INT);
            $req->bindValue(':premier', $premier, \PDO::PARAM_INT);
            $req->bindValue(':parpage', $parPage, \PDO::PARAM_INT);
            $req->execute();
            $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        } elseif ($fullRequestWithSubCategory){

            $sql .= $fullRequestWithSubCategory;
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

    public function getProductWithoutFilter (?string $whereIdCategory, ?int $id_category, ?string $whereIdSubCategory, ?string $all, ?int $id_subcategory, int $premier, int $parPage) {

        $bdd = $this->getBdd();
        $sql = "SELECT id_product, name, description, price, id_category, id_subcategory, date_product, img_product FROM product";

        if($whereIdCategory) {
            $sql .= $whereIdCategory;
            $req = $bdd->prepare($sql);
            $req->bindValue(':id_category', $id_category, \PDO::PARAM_INT);
            $req->bindValue(':premier', $premier, \PDO::PARAM_INT);
            $req->bindValue(':parpage', $parPage, \PDO::PARAM_INT);
            $req->execute();
            $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        } elseif ($whereIdSubCategory) {
            $sql .= $whereIdSubCategory;
            $req = $bdd->prepare($sql);
            $req->bindValue(':id_subcategory', $id_subcategory, \PDO::PARAM_INT);
            $req->bindValue(':premier', $premier, \PDO::PARAM_INT);
            $req->bindValue(':parpage', $parPage, \PDO::PARAM_INT);
            $req->execute();
            $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        } elseif($all) {
            $sql .= $all;
            $req = $bdd->prepare($sql);
            $req->bindValue(':premier', $premier, \PDO::PARAM_INT);
            $req->bindValue(':parpage', $parPage, \PDO::PARAM_INT);
            $req->execute();
            $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        }

        return $result;
    }


}