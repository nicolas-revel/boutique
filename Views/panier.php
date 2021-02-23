<?php
require_once('components/classesViewHeader.php');
require_once('components/classesViewPanier.php');
require_once '../vendor/autoload.php';
session_start();

$contprofil = new \app\controllers\controllerprofil();
$viewPanier = new \app\views\components\viewPanier();
$controlPanier = new \app\controllers\Controllerpanier();

if (isset($_GET['delivery']) && isset($_POST['add_new_adress'])) {
    try {
        $contprofil->insertAdress($_SESSION['user']->getId_user(), $_POST['title'], $_POST['country'], $_POST['town'], $_POST['postal_code'], $_POST['street'], $_POST['infos'], $_POST['number']);
    } catch (\PDOException $e) {
        $error_msg = $e->getMessage();
    }
}

$pageTitle = 'PRODUIT';
ob_start();
require_once('../config/header.php');
?>

<main>

    <!-- PAGE PANIER + POSSIBILITE MODIFICATION DU PANIER -->

    <?php if(isset($_SESSION['panier']) && !isset($_GET['delivery']) && !isset($_GET['expedition']) && !isset($_GET['checkout'])): ?>
    <a href="boutique.php">Continuez vos achats ></a>
    <?php if(!empty($_SESSION['panier'])){ var_dump($_SESSION['panier']);} ?>

        <table>
            <tr>
                <td><?php $viewPanier->showImagePanier(); ?></td>
                <td><?php $viewPanier->showNamePanier(); ?></td>
                <td><?php $viewPanier->showQuantityPanier(); ?></td>
                <td><?php $viewPanier->showPricePanier(); ?></td>
                <td><?php $viewPanier->showPriceTotalProductPanier(); ?></td>
                <?php if(isset($_POST['modifier'])){
                        $controlPanier->modifQuantityFromPanier ();
                        Header('Location: panier.php');} ?>
                <td><?php $viewPanier->showDeleteButton (); ?></td>
                <?php if(isset($_POST['delete'])){
                    $controlPanier->deleteFormProduct();
                    Header('Location: panier.php');} ?>
            </tr>
        </table>
    <?= $controlPanier->countPricePanier(); ?>
    <form action="panier.php" method='post'>
        <button type='submit' name='deletePanier'>Vider le panier</button></form>
    <?php if(isset($_POST['deletePanier'])){
        $controlPanier->getEmptyPanier();
        Header('Location: panier.php');} ?>

    <a href="panier.php?delivery=infos">Valider le panier</a>
    <?php endif; ?>

    <!-- PAGE INFORMATION COMMANDE -->

    <?php if(isset($_SESSION['panier']) && isset($_GET['delivery']) && !isset($_GET['checkout'])): ?>
        <?php if(!empty($_SESSION['panier'])){ var_dump($_SESSION['panier']);} ?>

    <?php if(!isset($_SESSION['user']) && empty($_SESSION['user'])): ?>
    <div id="noConnect">
        <p>Pas encore inscrit? <a href="Inscription.php">Rejoins-nous</a></p>
        <p>Déjà membre? <a href="connexion.php">Connecte-toi</a></p>
    </div>
    <?php endif; ?>

    <section id="modifFormAdress">
        <h2>Adresse d'expédition :</h2>
        <?= $viewPanier->showAdressUser (); ?>
        <?php if(isset($_POST['choose'])){
            $controlPanier->addAdressPanier ();
        } ?>

        <h2>Ajouter une nouvelle adresse d'expédition : </h2>
        <form action="moncompte.php" method="POST">
            <div class="form-item">
                <label for="title">Donnez un nom à cette adresse :</label>
                <input type="text" name="title" id="title" placeholder="ex : Appartement perso" required>
            </div>
            <div class="form-item">
                <label for="country">Pays :</label>
                <input type="text" name="country" id="country" placeholder="ex : France" required>
            </div>
            <div class="form-item">
                <label for="town">Ville :</label>
                <input type="text" name="town" id="town" placeholder="ex : Marseille" required>
            </div>
            <div class="form-item">
                <label for="postal_code">Code Postal :</label>
                <input type="text" name="postal_code" id="postal_code" placeholder="ex : 13001" required>
            </div>
            <div class="form-item">
                <label for="street">Rue :</label>
                <input type="text" name="street" id="street" placeholder="ex : Rue d'Hozier" required>
            </div>
            <div class="form-item">
                <label for="infos">Infos supplémentaires :</label>
                <input type="text" name="infos" id="infos" placeholder="ex : Appartement 8">
            </div>
            <div class="form-item">
                <label for="number">Numéro de rue :</label>
                <input type="number" name="number" id="number" spellcheck="true" required>
            </div>
            <input type="submit" value="Ajouter l'adresse" name="add_new_adress">
        </form>

    </section>
    <div id="redirection">
        <a href="panier.php">Retour panier</a>
    </div>
    <br>
        <table>
            <tr>
                <td><?php $viewPanier->showImagePanier(); ?></td>
                <td><?php $viewPanier->showNamePanier(); ?></td>
                <td><?php $viewPanier->showQuantityPanier(); ?></td>
                <td><?php $viewPanier->showPricePanier(); ?></td>
                <td><?php $viewPanier->showPriceTotalProductPanier(); ?></td>
            </tr>
        </table>

        <p>Sous-total: </p><?= $controlPanier->countPricePanier(); ?>
        <p>Total (taxe de 2,00€ incluse):</p><?= $controlPanier->countPricePanierWithTaxe (); ?>
        <br>

        <form method="post" action="panier.php?delivery=infos">
            <input type="submit" name="expedition" value="expedition">
        </form>
        <?php if(isset($_POST['expedition'])){
            Header('Location: panier.php?expedition=type');
        } ?>

    <?php endif; ?>

    <!-- PAGE PANIER TYPE D'EXPEDITION -->

    <?php if(isset($_SESSION['panier']) && isset($_GET['expedition']) && !isset($_GET['delivery']) && !isset($_GET['checkout'])): ?>
        <?php if(!empty($_SESSION['panier'])){ var_dump($_SESSION['panier']);} ?>
            <?php if(isset($_SESSION['user'])): ?>

        <div id="recupInfosUser">
            <span>EMAIL : <?= $_SESSION['user']->getEmail(); ?></span><br>
            <span>EXPEDIER A : <?= $_SESSION['panier']['adress'][0] ?></span>
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
        <table>
            <tr>
                <td><?php $viewPanier->showImagePanier(); ?></td>
                <td><?php $viewPanier->showNamePanier(); ?></td>
                <td><?php $viewPanier->showQuantityPanier(); ?></td>
                <td><?php $viewPanier->showPricePanier(); ?></td>
                <td><?php $viewPanier->showPriceTotalProductPanier(); ?></td>
            </tr>
        </table>

        <p>Sous-total: </p><?= $controlPanier->countPricePanier(); ?>
        <p>Total (taxe de 2,00€ incluse):</p><?= $controlPanier->countPricePanierWithTaxe (); ?>
        <p>Frais de livraison :</p><?= $viewPanier->showFraisLivraison(); ?>
        <p>Total : </p><?= $viewPanier->showTotalWithFraisExpedition(); ?>
            <br>

        <a href="panier.php?checkout">Paiement</a>
    <?php endif; ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['panier']) && !isset($_GET['expedition']) && !isset($_GET['delivery']) && isset($_GET['checkout'])): ?>
        <?php if(isset($_SESSION['panier']) && !empty($_SESSION['panier'])){

            $prix = $_SESSION['panier']['totalFraisLivraison'][0];

            //On instancie stripe.
           \Stripe\Stripe::setApiKey('sk_test_51INyY2KomI1Ouv8d9tPqAlc1IXZalzWEQCdC0ODd83e4Ow39THFZf3CjsjVZNbi7E8SwKEBVSuqu7Ly505UdBqry00RoWeYAQ1');

            $intent = \Stripe\PaymentIntent::create([
                'amount' => $prix*100,
                'currency' => 'eur'
            ]);

        } ?>
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
</main>


<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
