<?php


namespace app\views\components;

require'../vendor/autoload.php';

class viewProduct extends \app\controllers\Controllerproduit
{

    /**
     * Méthode qui permet d'afficher l'image du produit
     */
    public function showImageProduct()
    {
        $tableProduct = $this->getOneProduct();

        foreach($tableProduct as $key => $value){
            echo " <div id='imageProduct'>
                        <img id='pictureOneProduct' alt='Photo du produit' src='../images/imageboutique/".$value['img_product']."'>
                   </div>";
        }
    }

    public function showInfosProduct()
    {
        $tableProduct = $this->getOneProduct();

        foreach($tableProduct as $key => $value) {

            $date = strftime('%d-%m-%Y', strtotime($value['date_product']));
            $price = $value['price'];

            echo " <div id='cardInfosProduct'>
                      <h6 id='titleNameProduct' class='flow-text'>" . $value['name'] . "</h6>
                      <small id='dateProduct' class='flow-text'>Ajouté le : $date</small><br>";

                    if ($value['stocks'] == 0) {
                        echo "<small id='stockProduct' class='flow-text'>Produit indisponible en stock</small>";
                    } else {
                        echo "<small id='stockProduct' class='flow-text'>Il reste (" . $value['stocks'] . " exemplaires).</small>";
                    }

                echo "<p id='priceProduct' class='flow-text'>" . number_format($price, 2, ',', ' ') . " €</p>
                      <p id='descriptionProduct' class='flow-text'>" . $value['description'] . "</p>
                  </div>";

        }
    }

    public function showButtonPanier ($get) {

        $tableProduct = $this->getOneProduct();

        foreach($tableProduct as $k => $v){
            if($v['stocks'] == 0){
                echo "<p id='error' class='flow-text'>Le produit est momentanément indisponible.</p>";
            } else {
                echo "<a class='add' href='addpanier.php?id=<?= $get ?>'>AJOUTER AU PANIER</a>";
            }
        }
    }


    public function showCommentProduct()
    {
        $stars = new \app\views\components\viewAccueil();
        $tableComment = $this->getCommentProduct();

        foreach($tableComment as $key => $value){

            $dateFr = strftime('%d-%m-%Y', strtotime($value['date_comment']));

            echo "<div id='cardLastComment'>
                       <p class='chip'>Ecrit par :  <b>".$value['firstname']."</b> le $dateFr</p>
                           ".$stars->ratingStarsGrey($value['rating'])."
                            ".$stars->ratingStarsOrange($value['rating'])."
                                <h5 id='titleProductComment'>".$value['name']."</h5>
                                    <p id='contentComment'>".$value['content']."</p>
                                       </div>";
        }
    }

    public function showButonAddProduct (){

        if(isset($_SESSION['panier']) && $_GET['product']){

            $verifProduct = $this->verifProductPanier($_GET['product']);

            if($verifProduct == false){
                echo "<input type='submit' name='panier' value='AJOUTER AU PANIER'>";
            }else{
                echo "<input type='submit' name='delete' value='RETIRER DU PANIER'>";
            }
        }
    }

    public function showFormComment () {

        if(!isset($_SESSION['user']) && empty($_SESSION['user'])){
            echo "<p class='flow-text'>Rejoins-nous ou connecte-toi et partage ton expérience Jungle Gardener avec les autres internautes, afin que nous puissions améliorer nos services pour vous.</p>
                    <div id='buttonConnect'>
                        <a class='add' href='inscription.php'>INSCRIPTION</a>
                        <a class='add' href='connexion.php'>CONNEXION</a></div>";
        }
    }

    }


