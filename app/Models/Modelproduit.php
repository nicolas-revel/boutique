<?php


namespace app\Models;


class Modelproduit extends model
{
        public function addCommentBdd ($id_user, $id_product, $comment, $note): void {

            $bdd = $this->getBdd();

            $req = $bdd->prepare("INSERT INTO comment (id_user, id_product, date_comment, content, rating) VALUES (:id_user, :id_product, NOW(), :content, :rating)");
            $req->bindValue(':id_user', $id_user);
            $req->bindValue(':id_product', $id_product);
            $req->bindValue(':content', $comment);
            $req->bindValue(':rating', $note);
            $req->execute() or die(print_r($req->errorInfo()));

        }
}