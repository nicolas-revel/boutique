<?php
require_once('../config/config.php');

// Suppression d'un produit dans le panier
if(isset($_GET['del'])){
    $controlPanier->delProductId($_GET['del']);
}

//Modification de la quantité via le panier
if (isset($_POST['modifier'])) {
    try {
        $controlPanier->modifQuantity();
    } catch (\Exception $e) {
        $error_msg = $e->getMessage();
    }
}

//Choix dans adresse déjà existantes / sauvegarde de l'adresse dans une session
if (isset($_POST['select_adress'])) {
    $controlPanier->addAdressPanier();
    Header('Location: panier.php?delivery=infos');
}

//Choix type d'expedition et sauvegarde dans une session
if (isset($_POST['valider'])) {
    $controlPanier->addExpeditionType();
    Header('Location: panier.php?expedition=type');
}
//effacement du panier arpès paiement
if (isset($_POST['back'])) {
    $controlPanier->paiementAccepte();
    header('Location: accueil.php');
}

//Insertion de la commande en base de donnée après paiement validé
if (isset($_GET['command'])) {
    $controlPanier->insertShipping();
}

ob_start();
require_once('../config/header.php');
?>

<main id="mainBoutique">
    <article id="panierDetails">

        <!-- Page panier, possibilité de modifier les quantités, retourner sur la boutique ou valider le panier -->

        <?php if(!isset($_GET['delivery']) && !isset($_GET['expedition']) && !isset($_GET['checkout']) && !isset($_GET['command'])): ?>
            <?php $pageTitle = 'PANIER'; ?>
                <div class="titlePanier">
                    <h6 class="flow-text" id="tPanier">MON PANIER</h6>
                </div>
                <?php if(!isset($_SESSION['panier']) || empty($_SESSION['panier'])): ?>
                    <?php $viewPanier->emptyPanier(); ?>
                <?php endif; ?>
            <form method="post" action="panier.php">
                <div class="table">
                    <div class="wrap">
                        <?= $viewPanier->showPanier(); ?>
                    </div>
                </div>
                <?php if(isset($error_msg)) : ?>
                    <p class="error_msg_shop2">
                        <?= $error_msg; ?>
                    </p>
                <?php endif; ?>
            </form>
        <div class="validPanier">
            <a class="lienBackPanier" href='boutique.php'>< boutique</a>
            <a class="lienBackShop" href="panier.php?delivery=infos">Valider le panier ></a>
        </div>
    <?php endif; ?>

        <!-- PAGE INFORMATION COMMANDE, Choix entre les adresses existantes de l'utilisateur ou possibilité d'en ajouter une nouvelle
         et si "invité", ajout des différentes informations-->

        <?php if(isset($_SESSION['panier']) && isset($_GET['delivery']) && !isset($_GET['checkout']) && !isset($_GET['command']) && !isset($_GET['expedition'])): ?>
            <?php $pageTitle = 'INFORMATIONS COMMANDE'; ?>
                <div class="titlePanier">
                    <h6 class="flow-text" id="tPanier">INFORMATIONS COMMANDE</h6>
                </div>
            <section id="modifFormAdress">
                <div id="chooseAdress">
                    <div id="redirection">
                        <a class="buttonFilter" href="boutique.php">< Retour boutique</a>
                    </div>
                    <img src="../images/imagessite/pot.gif" id="gifPot" alt="animation pot">

                    <?php if(!isset($_SESSION['user']) && empty($_SESSION['user'])): ?>
                        <div id="noConnect">
                            <h4 id="heyTitle">HEY TOI !</h4>
                            <p class="flow-text" id="textConnect">N'hésites pas à t'inscrire ou te connecter et sauvegarde tes informations pour tes prochaines commande !</p>
                            <div id='co'>
                                <a class="lienBackShop" href="inscription.php">Rejoins-nous</a>
                                <a class="lienBackPanier" href="connexion.php">Connecte-toi</a>
                            </div>
                        </div>
                    <?php else: ?>
                    <div id="noConnect">
                        <h4 id="heyTitle">HEY <?= $_SESSION['user']->getFirstname() ?> !</h4>
                        <p class="flow-text" id="textConnect">Choisie ton adresse de livraison dans celle déjà existantes ou ajoutes-en une nouvelle !</p>
                    </div>
                        <?php if(!isset($_SESSION['adress']) && empty($_SESSION['adress'])): ?>
                            <form id="formRadio" action='panier.php?delivery=infos' method='post'>
                                <h6 id="titleMyAdress">Mes adresses :</h6>
                                <?= $viewPanier->showAdressUser (); ?>
                                <input class='buttonFilter' type='submit' name='select_adress' value='Choisir'>
                            </form>
                            <?php elseif(isset($_SESSION['adress']) && !empty($_SESSION['adress'])): ?>
                                <div class="blockMessage2">
                                    <p class="msgGood2">Votre choix a bien été pris en compte.</p>
                                </div>
                            <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php if(empty($_SESSION['lastname']) && empty($_SESSION['firstname']) && empty($_SESSION['email']) && empty($_SESSION['adress_Name'])): ?>
                    <?php $viewPanier->showFormAddAdress (); ?>
                <?php else: ?>
                    <div id="formNewAdress">
                        <div id="blockMessage">
                            <p id="msgGood">Votre nouvelle adresse à bien été prise en compte.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </section>
            <div class="titlePanier">
                <h6 class="flow-text" id="tPanier">MON PANIER</h6>
            </div>
            <div class="table">
                <div class="wrap">
                    <?= $totalPrice = $viewPanier->showPanier(); ?>
                </div>
                <p id="totalTaxe">TOTAL <i>(taxe de 2,00€ incluse)</i>: <b><?= number_format($controlPanier->totalPrice() + 2,2,',',' ') ?> €</b></p>
            </div>
            <div class="validPanier">
                <a class="lienBackPanier" href='panier.php'>< retour panier</a>
                <a class="lienBackShop" href="panier.php?expedition=type">Expédition ></a>
            </div>
        <?php endif; ?>

        <!-- PAGE PANIER TYPE D'EXPEDITION, Choix des différents type d'expédition -->

        <?php if(isset($_SESSION['panier']) && isset($_GET['expedition']) && !isset($_GET['delivery']) && !isset($_GET['checkout']) && !isset($_GET['command'])): ?>
            <?php $pageTitle = 'EXPEDITION'; ?>

                <div class="titlePanier">
                    <h6 class="flow-text" id="tPanier">EXPEDITION</h6>
                </div>
            <section id="chooseExpe">
                <?php if(empty($_SESSION['fraisLivraison']) && empty($_SESSION['totalCommand'])): ?>

            <form id="formChooseExpe" method="post" action="panier.php?expedition=type">
                <h4 id="titleFormExpe">MODE D'EXPEDITION :</h4>
                <div id="inp_radio">
                    <label for="prioritaire">
                        <input name="envoie" id="prioritaire" value="7.56" type="radio">
                        <span>Envoie prioritaire</span>
                    </label>
                </div>
                <div>
                    <label for="colissimo">
                        <input name="envoie" id="colissimo" value="6.45" type="radio">
                        <span>Envoie Colissimo</span>
                    </label>
                </div>
                <div>
                    <label for="magasin">
                        <input id="magasin" name="envoie" value="0" type="radio">
                        <span>A retirer en magasin</span>
                    </label>
                </div>
                <input class="buttonFilter" type="submit" name="valider" value="valider">
            </form>
                <?php else: ?>
                    <div class="blockMessage3">
                        <p class="msgGood3">Votre choix a bien été pris en compte.</p>
                    </div>
                <?php endif; ?>
                    <div id="recupInfosUser">
                        <p id="recapMail"><b>EMAIL :</b> <?php if(isset($_SESSION['user'])){ echo $_SESSION['user']->getEmail(); }else{ echo $_SESSION['email']; }?></p><br>
                        <p id="recapAdress"><b>EXPEDIER A :</b> <?php if(isset($_SESSION['adress'])){ echo $_SESSION['adress']; }else{ echo $_SESSION['adress_Name']; } ?></p>
                    </div>
            </section>
            <div class="titlePanier">
                <h6 class="flow-text" id="tPanier">MON PANIER</h6>
            </div>
                <div class="table">
                    <div class="wrap">
                        <?php $totalprice = $viewPanier->showPanier(); ?>
                    </div>
                </div>
            <div id="pricesTotal">
                <p>Total (taxe de 2,00€ incluse):  <b><?= number_format($controlPanier->totalPrice() + 2,2,',',' ') ?> €</b></p>
                <p>Frais de livraison : <b><?php if(isset($_SESSION['fraisLivraison'])){ echo number_format($_SESSION['fraisLivraison'],2,',',' ') .'€'; }else{  echo '0,00 €'; }?></b></p>
                <p>Total : <b><?php if(isset($_SESSION['totalCommand'])){ echo number_format($_SESSION['totalCommand'], 2, ',', ' ').' €'; }else{ echo '0,00 €'; }?></b></p>
            </div>
        <div class="validPanier">
            <a type="submit" class="lienBackShop" href="panier.php?checkout">PAIEMENT ></a>
        </div>

            <?php endif; ?>

        <!-- PAGE PAIEMENT STRIPE -->
        <?php if(isset($_SESSION['panier']) && !isset($_GET['expedition']) && !isset($_GET['delivery']) && isset($_GET['checkout']) && !isset($_GET['command'])): ?>
            <?php $pageTitle = 'PAIEMENT'; ?>
            <?php if(isset($_SESSION['panier']) && !empty($_SESSION['panier'])){

                $prix = $_SESSION['totalCommand'];
                $intent = $controlPanier->stripeForm ($prix);

            } ?>
            <div class="titlePanier">
                <h6 class="flow-text" id="tPanier">PAIEMENT</h6>
            </div>

            <section id="finalCommand">
                <div class="table2">
                    <div class="wrap">
                        <?php $totalprice = $viewPanier->showPanier(); ?>
                    </div>
                    <div id="pricesTotal3">
                        <p>Total (taxe de 2,00€ incluse):  <b><?= number_format($controlPanier->totalPrice() + 2,2,',',' ') ?> €</b></p>
                        <p>Frais de livraison : <b><?php if(isset($_SESSION['fraisLivraison'])){ echo number_format($_SESSION['fraisLivraison'],2,',',' ') .'€'; }else{  echo '0,00 €'; }?></b></p>
                        <p>Total : <b><?php if(isset($_SESSION['totalCommand'])){ echo number_format($_SESSION['totalCommand'], 2, ',', ' ').' €'; }else{ echo '0,00 €'; }?></b></p>
                    </div>
                </div>

            <form id="formPayment" method="post">
                <div id="titlePay">
                    <h6 id="titleP">PAIEMENT</h6>
                </div>
                <div id="errors"></div><!-- Contiendra les messages d'erreurs de paiement -->
                <input type="text" id="cardholder_name" placeholder="Titulaire de la carte">
                <br>
                <div id="card-elements"></div><!-- Contiendra le formulaire de saisie des informations de carte -->
                <br>
                <div id="card_errors" role="alert"></div><!-- Contiendra les erreurs relative à la carte -->
                <button class="buttonFilter" id="card-button" type="button" data-secret="<?= $intent['client_secret'] ?>">Procéder au paiement</button>
            </form>

            </section>
        <?php endif; ?>

        <!-- PAGE PAIEMENT VALIDE, page avec récap de la commande, confirmation paiement validé et affichage de l'adresse d'expédition -->

        <?php if(isset($_GET['command']) && !isset($_GET['delivery']) && !isset($_GET['expedition']) && !isset($_GET['checkout'])): ?>
        <?php $pageTitle = 'CONFIRMATION COMMANDE'; ?>

        <section id="confirmPayment">
            <div id="confirmAddCommand">
                <img src="../images/imagessite/confirmCommand.gif" id="gifConfirm" alt="Animation confirmation Paiement">
                <div id="titleConfirmP">
                    <h5 id="transac">Transaction bancaire réussie.</h5>
                    <h5 id="thanks">Merci pour ta commande et à bientôt ! </h5>
                </div>
            </div>

        <section id="finalCommand">
            <div class="table3">
                <div class="wrap">
                    <?php $viewPanier->showPanier(); ?>
                </div>
                <div id="pricesTotal3">
                    <p>Total (taxe de 2,00€ incluse):  <b><?= number_format($controlPanier->totalPrice() + 2,2,',',' ') ?> €</b></p>
                    <p>Frais de livraison : <b><?php if(isset($_SESSION['fraisLivraison'])){ echo number_format($_SESSION['fraisLivraison'],2,',',' ') .'€'; }else{  echo '0,00 €'; }?></b></p>
                    <p>Total : <b><?php if(isset($_SESSION['totalCommand'])){ echo number_format($_SESSION['totalCommand'], 2, ',', ' ').' €'; }else{ echo '0,00 €'; }?></b></p>
                </div>
            </div>
            <div id="detailsAdressUser">
                <?php if(!empty($_SESSION['user'])): ?>
                    <?php $viewPanier->showDetailsExpedition (intval($_SESSION['user']->getId_user())); ?>
                <?php else: ?>
                    <?php $viewPanier->showDetailsGuest (); ?>
                <?php endif; ?>
            </div>
        </section>
            <div class="validPanier">
                <form method="post">
                    <button type="submit" class="lienBackPanier" name="back">retour accueil</button>
                </form>
            </div>
        <?php endif; ?>
    </article>
</main>
    <script type="text/javascript" src="../js/stripe.js"></script>
<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
