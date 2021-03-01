<?php


namespace app\views\components;

require'../vendor/autoload.php';


class ViewPanier extends \app\controllers\Controllerpanier
{

    public function showPanier () {

        $ids = array_keys($_SESSION['panier']);

        if(empty($ids)){
            $products = array();
        }else{
            $products = $this->getProductById($ids);
        }
                foreach($products as $product){ ?>

                    <div class="row">
                        <a href="#" class="img"><img id="imgP" src="../images/imageboutique/<?= $product->img_product ?>"></a>
                        <span class="name"><?= $product->name ?></span>
                        <span class="price"><?= number_format($product->price,2,',',' ') ?> €</span>

                        <span class="quantity">
                            <?php if(!isset($_GET['delivery']) && !isset($_GET['expedition'])): ?>
                                    <input type='number' id='quantity' name='panier[quantity][<?= $product->id_product ?>]' min='1' value='<?= $_SESSION['panier'][$product->id_product]; ?>'>
                            <?php else: ?>
                                    <?= $_SESSION['panier'][$product->id_product]; ?>
                            <?php endif; ?>
                        </span>

                        <span class="subtotalQuantity"><?= $this->getTotalPriceByProduct ($product->price, $product->id_product) ?> €</span>
                        <span class="action">
                            <a href="panier.php?del=<?= $product->id_product ?>" class="del"><i class="fas fa-trash-alt"></i></a>
                        </span>
                    </div>
                    <?php
                } ?>

            <?php if(!isset($_GET['delivery']) && !isset($_GET['expedition'])): ?>
                <input class="buttonFilter" type="submit" value="Modifier la quantité" name="modifier">
            <?php else: ?>
            <?php endif; ?>

        <?php if(isset($_POST['modifier'])){ $this->modifQuantity(); Header('Location: panier.php');} ?>
        <span class="subTotal">Sous-Total : <b><?= number_format($this->totalPrice(),2,',',' ') ?> €</b></span><br>
        <?php
    }


    public function showAdressUser ()
    {
        if (isset($_SESSION['user']) && !empty($_SESSION['user']->getId_user())) {

            $contprofil = new \app\controllers\controllerprofil();
            $user_adresses = $contprofil->getAdressById_user($_SESSION['user']->getId_user());

            if (gettype($user_adresses) === 'array'){
                foreach ($user_adresses as $adress){
                    echo "<p>
                              <label>
                                <input class='with-gap' name='choose_adress' type='radio' value='".$adress->getTitle()."' />
                                <span>".$adress->getTitle()."</span>
                              </label>
                            </p>";
                }
            }
        }
    }


}