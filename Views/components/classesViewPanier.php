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

                    <div id="rowP" class="row">
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
            <?php endif; ?>

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
                    echo " <p>
                              <label>
                                <input class='with-gap' name='choose_adress' type='radio' value='".$adress->getTitle()."' />
                                <span>".$adress->getTitle()."</span>
                              </label>
                            </p>";
                }
            }
        }
    }

    public function showFormAddAdress () { ?>

        <div id="formNewAdress">
            <h6 id="addAdressTitle">Ajouter une nouvelle adresse d'expédition : </h6>
                <br>
            <form action="panier.php?delivery=infos" method="post">

                <?php if(!isset($_SESSION['user']) && empty($_SESSION['user'])): ?>
                    <div class="form-item">
                        <label for="title">Votre nom :</label>
                        <input type="text" name="lastname" id="title" placeholder="Nom de famille">
                    </div>
                    <div class="form-item">
                        <label for="country">Votre prénom :</label>
                        <input type="text" name="firstname" id="country" placeholder="Prénom">
                    </div>
                    <div class="input-field">
                        <label for="email">Votre email :</label>
                        <input type="email" name="email" id="email" spellcheck="TRUE">
                    </div>
                <?php endif; ?>

                <div class="form-item">
                    <label for="title">Donnez un nom à cette adresse :</label>
                    <input type="text" name="title" id="title" placeholder="ex : Appartement perso">
                </div>
                <div class="form-item">
                    <label for="country">Pays :</label>
                    <input type="text" name="country" id="country" placeholder="ex : France">
                </div>
                <div class="form-item">
                    <label for="town">Ville :</label>
                    <input type="text" name="town" id="town" placeholder="ex : Marseille">
                </div>
                <div class="form-item">
                    <label for="postal_code">Code Postal :</label>
                    <input type="text" name="postal_code" id="postal_code" placeholder="ex : 13001">
                </div>
                <div class="form-item">
                    <label for="street">Rue :</label>
                    <input type="text" name="street" id="street" placeholder="ex : Rue d'Hozier">
                </div>
                <div class="form-item">
                    <label for="infos">Infos supplémentaires :</label>
                    <input type="text" name="infos" id="infos" placeholder="ex : Appartement 8">
                </div>
                <div class="form-item">
                    <label for="number">Numéro de rue :</label>
                    <input type="number" name="number" id="number" spellcheck="true">
                </div>
            <input class="buttonFilter" type="submit" value="Ajouter l'adresse" name="add_new_adress">

                <?php if(isset($_GET['delivery']) && isset($_POST['add_new_adress']) && empty($_SESSION['user'])) {
                try {
                    $this->insertAdressFromPanier (null,$_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['title'], $_POST['country'], $_POST['town'], $_POST['postal_code'], $_POST['street'], $_POST['infos'], $_POST['number']);
                    Header('Location: panier.php?delivery=infos');
                } catch (\Exception $e) {
                $error_msg = $e->getMessage();
                }}?>

                <?php if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_POST['add_new_adress'])){
                    try{
                        $this->insertAdressFromPanier ($_SESSION['user']->getId_user(),$_SESSION['user']->getFirstname(), $_SESSION['user']->getLastname(), $_SESSION['user']->getEmail(), $_POST['title'], $_POST['country'], $_POST['town'], $_POST['postal_code'], $_POST['street'], $_POST['infos'], $_POST['number']);
                        Header('Location: panier.php?delivery=infos');
                    }catch (\Exception $e) {
                        $error_msg = $e->getMessage();
                    }}?>

                <?php if(isset($error_msg)) : ?>
                    <p class="error_msg_shop2">
                        <?= $error_msg; ?>
                    </p>
                <?php endif; ?>
            </form></div>
<?php
    }


}