<?php


namespace app\views\components;

require'../vendor/autoload.php';


class ViewPanier extends \app\controllers\Controllerpanier
{
    public function showImagePanier(){

        if(isset($_SESSION['panier']) && !empty($_SESSION['panier'])){
            $table = $_SESSION['panier'];

            foreach($table as $key => $value){

                if(is_array($value)){
                    foreach($value as $keys => $values){
                        if($key == 'img_product') {
                            echo "<td><img id='picturePanierProduct' alt='Photo du produit' src='../images/imageboutique/$values'></td><br>";
                        }
                    }
                }
            }
        }
    }

    public function showNamePanier (){

        if(isset($_SESSION['panier']) && !empty($_SESSION['panier'])){
            $table = $_SESSION['panier'];

            foreach($table as $key => $value){
                if(is_array($value)){
                    foreach($value as $keys => $values){
                        if($key == 'name'){
                            echo "<td><h6>$values</h6></td>";
                        }
                    }
                }
            }
        }
    }


    public function showPricePanier (){

        if(isset($_SESSION['panier']) && !empty($_SESSION['panier'])){
            $table = $_SESSION['panier'];

            foreach($table as $key => $value){
                if(is_array($value)){
                    foreach($value as $keys => $values){
                        if($key == 'price'){
                            echo "<td><p>$values</p></td>";
                        }
                    }
                }
            }
        }
    }

    public function showPriceTotalProductPanier (){

        if(isset($_SESSION['panier']) && !empty($_SESSION['panier'])){
            $table = $_SESSION['panier'];

            foreach($table as $key => $value){
                if(is_array($value)){
                    foreach($value as $keys => $values){
                        if($key == 'totalPrice'){
                            echo "<td><p>$values</p></td>";
                        }
                    }
                }
            }
        }
    }

    public function showFraisLivraison (){

        if(isset($_SESSION['panier']) && !empty($_SESSION['panier'])){
            $table = $_SESSION['panier'];

            foreach($table as $key => $value){
                if(is_array($value)){
                    foreach($value as $keys => $values){
                        if($key == 'fraisLivraison'){
                            echo "<p>$values</p>";
                        }
                    }
                }
            }
        }
    }

    public function showTotalWithFraisExpedition (){

        if(isset($_SESSION['panier']) && !empty($_SESSION['panier'])){
            $table = $_SESSION['panier'];

            foreach($table as $key => $value){
                if(is_array($value)){
                    foreach($value as $keys => $values){
                        if($key == 'totalFraisLivraison'){
                            echo "<p>$values</p>";
                        }
                    }
                }
            }
        }
    }

    public function showQuantityPanier (){

        if(isset($_SESSION['panier']) && !empty($_SESSION['panier'])){
            $table = $_SESSION['panier'];

            foreach($table as $key => $value){
                if(is_array($value)){
                    foreach($value as $keys => $values){
                        if($key == 'quantity'){ ?>
                            <?php if(!isset($_GET['delivery']) && !isset($_GET['expedition']) && !isset($_GET['checkout']) && !isset($_GET['command'])): ?>
                            <td><form action="panier.php" method='post'>
                                      <label for='quantity'>Quantité:</label>
                                           <input type='number' id='quantity' name='quantity' min='1' value='<?= $values ?>'>
                                    <input type='submit' name='modifier' value='Modifier'></form></td>
                            <?php else : ?>
                            <p><?= $values; ?></p>
                            <?php endif; ?>
                            <?php
                        }
                    }
                }
            }
        }

    }

    public function showDeleteButton () {

        if(isset($_SESSION['panier']) && !empty($_SESSION['panier'])){
            $table = $_SESSION['panier'];

            foreach($table as $key => $value){
                if(is_array($value)){
                    foreach($value as $keys => $values){
                        if($key == 'id_product'){ ?>
                                <?php if(!isset($_GET['delivery'])): ?>
                            <td><form action="panier.php" method='post'>
                                    <button type='submit' name='delete'><i class="fas fa-trash-alt"></i></form></td>
                                <?php endif; ?>
                            <?php
                        }
                    }
                }
            }
        }
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