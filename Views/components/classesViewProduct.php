<?php

namespace Views\components;

require '../vendor/autoload.php';

class viewProduct extends \app\controllers\Controllerproduit
{

  /**
   * Méthode qui permet d'afficher l'image du produit grande taille
   */
  public function showImageProduct()
  {
    $tableProduct = $this->getOneProduct();

    foreach ($tableProduct as $key => $value) {
      echo " <div id='imageProduct'>
                        <img id='pictureOneProduct' alt='Photo du produit' src='../images/imageboutique/" . $value['img_product'] . "'>
                   </div>";
    }
  }

  /**
   * Méthode qui permet d'afficher les details du produit
   */
  public function showInfosProduct()
  {
    $tableProduct = $this->getOneProduct();

    foreach ($tableProduct as $key => $value) {
      $date = strftime('%d-%m-%Y', strtotime($value['date_product']));
      $price = $value['price'];

      echo " <div id='cardInfosProduct'>
                      <h6 id='titleNameProduct' class='flow-text'>" . $value['name'] . "</h6>
                      <small id='dateProduct' class='flow-text'>Ajouté le : $date</small><br>";

      if ($value['stocks'] <= 0 || $value['product_availability']) {
        echo "<small id='stockProduct' class='flow-text'>Produit indisponible en stock</small>";
      } else {
        echo "<small id='stockProduct' class='flow-text'>Il reste (" . $value['stocks'] . " exemplaires).</small>";
      }

      echo "<p id='priceProduct' class='flow-text'>" . number_format($price, 2, ',', ' ') . " €</p>
                      <div id='descriptionProduct' class='flow-text'>" . $value['description'] . "</div>
                  </div>";
    }
  }

  /**
   * Méthode qui permet d'afficher le bouton 'ajouter au panier' selon le stocks du produit
   * @param $get
   */
  public function showButtonPanier($get)
  {

    $tableProduct = $this->getOneProduct();

    foreach ($tableProduct as $k => $v) {
      if ($v['stocks'] <= 0  || $v['product_availability'] == 2) {
        echo "<p id='error' class='flow-text'>Le produit est momentanément indisponible.</p>
                        <a class='lienBackShop2' href='boutique.php'>< Retour boutique</a>";
      } else {
        echo "<a class='add' href='addpanier.php?id=$get'><i class='fas fa-shopping-basket'></i>AJOUTER AU PANIER</a>
                        <a class='lienBackShop' href='boutique.php'>< Retour boutique</a>";
      }
    }
  }

    /**
     * Méthode qui permet d'afficher les commentaires du produit
     */
    public function showCommentProduct()
    {
        $stars = new \Views\components\viewAccueil();
        $tableComment = $this->getCommentProduct();

    foreach ($tableComment as $key => $value) {
      $dateFr = strftime('%d-%m-%Y', strtotime($value['date_comment']));

      echo "<div id='cardLastComment'>
                       <p class='chip'>Ecrit par :  <b>" . $value['firstname'] . "</b> le $dateFr</p>
                           " . $stars->ratingStarsGrey($value['rating']) . "
                            " . $stars->ratingStarsOrange($value['rating']) . "
                                <h5 id='titleProductComment'>" . $value['name'] . "</h5>
                                    <p id='contentComment'>" . $value['content'] . "</p>
                                       </div>";
    }
  }
}
