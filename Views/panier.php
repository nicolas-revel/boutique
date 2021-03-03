<?php
require_once('components/classesViewHeader.php');
require_once('components/classesViewPanier.php');
require_once '../vendor/autoload.php';

$contprofil = new \app\controllers\controllerprofil();
$viewPanier = new \app\views\components\viewPanier();
$controlPanier = new \app\controllers\Controllerpanier();


if(isset($_GET['del'])){ $controlPanier->delProductId($_GET['del']);}

$pageTitle = 'PANIER';
ob_start();
require_once('../config/header.php');
?>

<main id="mainBoutique">
    <article id="panierDetails">
    <?php if(!isset($_GET['delivery']) && !isset($_GET['expedition']) && !isset($_GET['checkout']) && !isset($_GET['command'])): ?>

    <div class="titlePanier">
        <h6 class="flow-text" id="tPanier">MON PANIER</h6>
    </div>
        <form method="post" action="panier.php">
            <div class="table">
                <div class="wrap">
                    <?= $viewPanier->showPanier(); ?>
                </div>
            </div>
            <?php if(isset($_POST['modifier'])){
                try {
                    $controlPanier->modifQuantity();
                }catch (\Exception $e) {
                    $error_msg = $e->getMessage();
                } }?>
            <?php if(isset($error_msg)) : ?>
                <p class="error_msg_shop2">
                    <?= $error_msg; ?>
                </p>
            <?php endif; ?>
        </form>
        <div class="validPanier">
            <a id="lienBackPanier" href='boutique.php'>< boutique</a>
            <a id="lienBackShop" href="panier.php?delivery=infos">Valider le panier ></a>
        </div>
    <?php endif; ?>


        <!-- PAGE INFORMATION COMMANDE -->

        <?php if(isset($_SESSION['panier']) && isset($_GET['delivery']) && !isset($_GET['checkout']) && !isset($_GET['command']) && !isset($_GET['expedition'])): ?>

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
                                <a id="lienBackShop" href="inscription.php">Rejoins-nous</a>
                                <a id="lienBackPanier" href="connexion.php">Connecte-toi</a>
                            </div>
                        </div>
                    <?php else: ?>
                    <div id="noConnect">
                        <h4 id="heyTitle">HEY <?= $_SESSION['user']->getFirstname() ?> !</h4>
                        <p class="flow-text" id="textConnect">Choisie ton adresse de livraison dans celle déjà existantes ou ajoutes-en une nouvelle !</p>
                    </div>
                            <?php if(empty($_SESSION['adress'])): ?>
                            <form id="formRadio" action='panier.php?delivery=infos' method='post'>
                                <h6 id="titleMyAdress">Mes adresses :</h6>
                                <?= $viewPanier->showAdressUser (); ?>
                                <input class='buttonFilter' type='submit' name='select_adress' value='Choisir'>
                            </form>
                            <?php if(isset($_POST['select_adress'])){
                                $controlPanier->addAdressPanier();
                                Header('Location: panier.php?delivery=infos');}?>
                            <?php else: ?>
                                <div id="blockMessage2">
                                    <p id="msgGood2">Votre choix été prise en compte.</p>
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
                <a id="lienBackPanier" href='panier.php'>< retour panier</a>
                <a id="lienBackShop" href="panier.php?expedition=type">Expédition ></a>
            </div>
        <?php endif; ?>

        <!-- PAGE PANIER TYPE D'EXPEDITION -->

        <?php if(isset($_SESSION['panier']) && isset($_GET['expedition']) && !isset($_GET['delivery']) && !isset($_GET['checkout']) && !isset($_GET['command'])): ?>

            <div class="titlePanier">
                <h6 class="flow-text" id="tPanier">EXPEDITION</h6>
            </div>

            <section id="chooseExpe">
            <form id="formChooseExpe" method="post" action="panier.php?expedition=type">
                <h4 id="titleFormExpe">MODE D'EXPEDITION :</h4>
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
                <input class="buttonFilter" type="submit" name="valider" value="valider">
                <?php if(isset($_POST['valider'])){
                    $controlPanier->addExpeditionType();
                    Header('Location: panier.php?expedition=type');
                } ?>
            </form>
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


            <a class="buttonFilter" href="panier.php?checkout">PAIEMENT ></a>
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
            <div class="titlePanier">
                <h6 class="flow-text" id="tPanier">PAIEMENT</h6>
            </div>

            <section id="finalCommand">
                <div class="table3">
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
                <button name="pay" class="buttonFilter" id="card-button" type="button" data-secret="<?= $intent['client_secret'] ?>">Procéder au paiement</button>
            </form>

            </section>
            <script src="https://js.stripe.com/v3/"></script>
            <script src="../js/stripe.js"></script>
        <?php endif; ?>

        <!-- PAGE PAIEMENT VALIDE -->
        <?php if(isset($_GET['command']) && !isset($_GET['delivery']) && !isset($_GET['expedition']) && !isset($_GET['checkout'])): ?>
            <?php if(isset($_GET['command'])){
                $controlPanier->insertShipping ();
            }?>
            <h2>Paiement accepté ! Merci pour votre commande ! </h2>
        <?php endif; ?>

    </article>
</main>


<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
