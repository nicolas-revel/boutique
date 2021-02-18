<?php


namespace app\Controllers;


class Controllerproduit extends \app\models\Modelproduit
{

        public function getOneProduct (){

            if(isset($_GET['product'])){

                $id_product = $_GET['product'];
                $product = $this->getOneProductBdd($id_product);
            }
            return $product;
        }

        public function getCommentProduct(){

            if(isset($_GET['product'])){
                $id_product = $_GET['product'];
                $productComment = $this->getCommentBddByProduct($id_product);
            }
            return $productComment;
        }


        public function addComment($id_user){

            if(!empty($_POST['commentProduct'])){

                $comment = htmlspecialchars(trim($_POST['commentProduct']));

                if(isset($_GET['product']) && isset($_GET['stars'])){

                    $id_product = $_GET['product'];
                    $note = $_GET['stars'];

                    $this->addCommentBdd($id_user, $id_product, $comment, $note);
                }
            }
        }


}