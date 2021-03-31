<?php


namespace app\Models;


class Modelproduit extends model
{
        /**
         * Méthode qui récupère en base de donnée un produit en particulier grâce à son id.
        * @param int $id_product
        * @return array
        */
        public function getOneProductBdd(int $id_product): array
        {

            $bdd = $this->getBdd();

            $req = $bdd->prepare("SELECT product.id_product, name, description, price, id_category, id_subcategory, date_product, img_product, product_availability, stocks.id_product, stocks.stocks FROM product INNER JOIN stocks ON product.id_product = stocks.id_product WHERE product.id_product = :id_product");
            $req->bindValue(':id_product', $id_product, \PDO::PARAM_INT);
            $req->execute();
            $result = $req->fetchAll(\PDO::FETCH_ASSOC);

            return $result;
        }

        /**
         * Méthode qui permet d'ajouter en base de donnée un commentaire
        * @param $id_user
        * @param $id_product
        * @param $comment
        * @param $note
        */
        public function addCommentBdd (int $id_user, int $id_product, string $comment, int $note): void {

            $bdd = $this->getBdd();

            $req = $bdd->prepare("INSERT INTO comment (id_user, id_product, date_comment, content, rating) VALUES (:id_user, :id_product, NOW(), :content, :rating)");
            $req->bindValue(':id_user', $id_user, \PDO::PARAM_INT);
            $req->bindValue(':id_product', $id_product, \PDO::PARAM_INT);
            $req->bindValue(':content', $comment, \PDO::PARAM_STR);
            $req->bindValue(':rating', $note, \PDO::PARAM_INT);
            $req->execute() or die(print_r($req->errorInfo()));

        }
}