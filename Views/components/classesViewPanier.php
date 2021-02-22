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
                            echo "<img id='picturePanierProduct' alt='Photo du produit' src='../images/imageboutique/$values'><br>";
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
                            echo "<h6>$values</h6>";
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
                            echo "<p>$values</p>";
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
                            <?php if(!isset($_GET['delivery'])): ?>
                            <form action="panier.php" method='post'>
                                      <label for='quantity'>Quantité:</label>
                                           <input type='number' id='quantity' name='quantity' min='1' value='<?= $values ?>'>
                                                <input type='submit' name='modifier' value='Modifier'></form>
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
                            <form action="panier.php" method='post'>
                                <button type='submit' name='delete'><i class="fas fa-trash-alt"></i></form>
                                <?php endif; ?>
                            <?php
                        }
                    }
                }
            }
        }
    }


}