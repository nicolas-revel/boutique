<?php


namespace app\Controllers;

require'../vendor/autoload.php';

class Controllerproduit extends \app\models\Modelproduit
{

    /**
     * Méthode qui recupère un produit selon son id récupérer dans un get
     * @return array
     */
    public function getOneProduct(): array
    {
        if (isset($_GET['product'])) {
            $id_product = $_GET['product'];
            $product = $this->getOneProductBdd(intval($id_product));
        }
        return $product;
    }

    /**
     * Méthode qui récupère les commentaires d'un produit par rapport à l'id passer dans le get
     * @return array
     */
    public function getCommentProduct(): array
    {
        if (isset($_GET['product'])) {
            $id_product = $_GET['product'];
            $productComment = $this->getCommentBddByProduct($id_product);
        }
        return $productComment;
    }

    /**
     * Méthode traitement du formulaire des commentaires et gestion des erreurs
     * @param $id_user
     * @return \Exception|void
     * @throws \Exception
     */
    public function addComment($id_user)
    {
        if (empty($_POST['commentProduct']) && empty($_GET['starts'])){
            throw new \Exception("* Merci de remplir les champs du formulaire.");
        }

        try {
            $comment = htmlspecialchars(trim($_POST['commentProduct']));
            if (isset($_GET['product']) && isset($_GET['stars'])) {
                $id_product = $_GET['product'];
                $note = $_GET['stars'];
                $add = $this->addCommentBdd($id_user, $id_product, $comment, $note);
            }
            return $add;
        } catch (\Exception $e) {
            return $e;
        }

    }


}



