<?php
require_once('components/classesViewHeader.php');
require_once('components/classesViewPanier.php');
require_once '../vendor/autoload.php';

$contprofil = new \app\controllers\controllerprofil();
$viewPanier = new \app\views\components\viewPanier();
$controlPanier = new \app\controllers\Controllerpanier();


if(isset($_GET['del'])){
    $controlPanier->delProductId($_GET['del']);
}

$pageTitle = 'PRODUIT';
ob_start();
require_once('../config/header.php');
?>

<main>

    <?php if(!isset($_GET['delivery']) && !isset($_GET['expedition']) && !isset($_GET['checkout']) && !isset($_GET['command'])): ?>
        <form method="post" action="panier.php">
            <div class="table">
                <div class="wrap">

                    <div class="rowtitle">
                        <span class="name">Product name</span>
                        <span class="price">Price</span>
                        <span class="quantity">Quantity</span>
                        <span class="subtotal">Subtotal</span>
                        <span class="action">Action</span>
                    </div>
                    <?= $viewPanier->showPanier(); ?>
                </div>
            </div>
        </form>
            <a href="panier.php?delivery=infos">Valider le panier</a>
    <?php endif; ?>

    <!-- PAGE INFORMATION COMMANDE -->

    <?php if(isset($_SESSION['panier']) && isset($_GET['delivery']) && !isset($_GET['checkout']) && !isset($_GET['command']) && !isset($_GET['expedition'])): ?>

        <?php if(!isset($_SESSION['user']) && empty($_SESSION['user'])): ?>
            <div id="noConnect">
                <p>Pas encore inscrit? <a href="inscription.php">Rejoins-nous</a></p>
                <p>Déjà membre? <a href="connexion.php">Connecte-toi</a></p>
            </div>
        <?php endif; ?>

        <section id="modifFormAdress">
            <h2>Adresse d'expédition :</h2>
            <form action="panier.php?delivery=infos" method="post">
                <?= $viewPanier->showAdressUser (); ?>


            <h2>Ajouter une nouvelle adresse d'expédition : </h2>

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
                <input type="submit" value="Ajouter l'adresse" name="add_new_adress">

                <?php if (isset($_GET['delivery']) && isset($_POST['add_new_adress'])) {
                try {
                $contprofil->insertAdress($_SESSION['user']->getId_user(), $_POST['title'], $_POST['country'], $_POST['town'], $_POST['postal_code'], $_POST['street'], $_POST['infos'], $_POST['number']);
                } catch (\PDOException $e) {
                $error_msg = $e->getMessage();
                }}?>
        </section>

        <div id="redirection">
            <a href="panier.php">Retour panier</a>
        </div>
        <div class="table">
            <div class="wrap">

                <div class="rowtitle">
                    <span class="name">Product name</span>
                    <span class="price">Price</span>
                    <span class="quantity">Quantity</span>
                    <span class="subtotal">Subtotal</span>
                    <span class="totalProduct">Total par produit</span>
                    <span class="action">Action</span>
                </div>
                <?php $totalprice = $viewPanier->showPanier(); ?>
            </div>
        </div>
        <p>Total (taxe de 2,00€ incluse):</p>Sous-Total : <?= number_format($controlPanier->totalPrice() + 2,2,',',' ') ?> €
        <br>

        <input type="submit" name="expedition" value="expedition">
        </form>
        <?php if(isset($_POST['expedition'])){$controlPanier->addAdressPanier (); Header('Location: panier.php?expedition=type');} ?>


    <?php endif; ?>

    <!-- PAGE PANIER TYPE D'EXPEDITION -->

    <?php if(isset($_SESSION['panier']) && isset($_GET['expedition']) && !isset($_GET['delivery']) && !isset($_GET['checkout']) && !isset($_GET['command'])): ?>
        <?php if(isset($_SESSION['user']) && isset($_SESSION['adress'])): ?>

            <div id="recupInfosUser">
                <span>EMAIL : <?= $_SESSION['user']->getEmail(); ?></span><br>
                <span>EXPEDIER A : <?= $_SESSION['adress'] ?></span>
            </div>

            <h4>MODE D'EXPEDITION :</h4>
            <form method="post" action="panier.php?expedition=type">
                <p>
                    <label>
                        <input class="with-gap" name="prioritaire" value="7.56" type="radio"  />
                        <span>Envoie prioritaire</span>
                    </label>
                </p>
                <p>
                    <label>
                        <input class="with-gap" name="colissimo" value="6.45" type="radio"  />
                        <span>Envoie Colissimo</span>
                    </label>
                </p>
                <p>
                    <label>
                        <input class="with-gap" name="magasin" value="0" type="radio"  />
                        <span>A retirer en magasin</span>
                    </label>
                </p>
                <input type="submit" name="valider" value="valider">
                <?php if(isset($_POST['valider'])){
                    $controlPanier->addExpeditionType();
                    Header('Location: panier.php?expedition=type');
                } ?>
            </form>

            <div class="table">
                <div class="wrap">

                    <div class="rowtitle">
                        <span class="name">Product name</span>
                        <span class="price">Price</span>
                        <span class="quantity">Quantity</span>
                        <span class="subtotal">Subtotal</span>
                        <span class="action">Action</span>
                    </div>
                    <?php $totalprice = $viewPanier->showPanier(); ?>
                </div>
            </div>

            <p>Total (taxe de 2,00€ incluse):</p>Sous-Total : <?= number_format($controlPanier->totalPrice() + 2,2,',',' ') ?> €
            <p>Frais de livraison :</p><?php if(isset($_SESSION['fraisLivraison'])){ echo number_format($_SESSION['fraisLivraison'],2,',',' ') .'€'; }else{  echo '0,00 €'; }?>
            <p>Total : </p><?php if(isset($_SESSION['totalCommand'])){ echo number_format($_SESSION['totalCommand'], 2, ',', ' ').' €'; }else{ echo '0,00 €'; }?>

            <form method="post" action="panier.php?expedition=type">
                <input type="submit" name="payment" value="PASSER AU PAIEMENT">
            </form>
            <?php if(isset($_POST['payment'])){
                $controlPanier->insertShipping ($_SESSION['totalPriceByProduct']);
                Header('Location: panier.php?checkout');
            }?>
        <?php endif; ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['panier']) && !isset($_GET['expedition']) && !isset($_GET['delivery']) && isset($_GET['checkout']) && !isset($_GET['command'])): ?>
        <?php if(isset($_SESSION['panier']) && !empty($_SESSION['panier'])){

            $prix = $_SESSION['totalCommand'];

            //On instancie stripe.
            \Stripe\Stripe::setApiKey('sk_test_51INyY2KomI1Ouv8d9tPqAlc1IXZalzWEQCdC0ODd83e4Ow39THFZf3CjsjVZNbi7E8SwKEBVSuqu7Ly505UdBqry00RoWeYAQ1');

            $intent = \Stripe\PaymentIntent::create([
                'amount' => $prix*100,
                'currency' => 'eur'
            ]);

        } ?>
        <?php var_dump($_SESSION['panier']); ?>
        <form method="post">
            <div id="errors"></div><!-- Contiendra les messages d'erreurs de paiement -->
            <input type="text" id="cardholder_name" placeholder="Titulaire de la carte">
            <div id="card-elements"></div><!-- Contiendra le formulaire de saisie des informations de carte -->
            <div id="card_errors" role="alert"></div><!-- Contiendra les erreurs relative à la carte -->
            <button id="card-button" type="button" data-secret="<?= $intent['client_secret'] ?>">Procéder au paiement</button>
        </form>


        <script src="https://js.stripe.com/v3/"></script>
        <script src="../js/stripe.js"></script>
    <?php endif; ?>

    <!-- PAGE PAIEMENT VALIDE -->
    <?php if(isset($_GET['command']) && !isset($_GET['delivery']) && !isset($_GET['expedition']) && !isset($_GET['checkout'])): ?>
        <?php $controlPanier->paiementAccepte();?>
        <h2>Paiement accepté ! Merci pour votre commande ! </h2>
    <?php endif; ?>
</main>


<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
