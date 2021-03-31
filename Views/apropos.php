<?php
require_once('../config/config.php');

if(isset($_POST['mailform'])){
    try{
        $text = $controlContact->formContact();
    }catch (Exception $e) {
        $error_msg = $e->getMessage();
    }
}

$pageTitle = 'QUI SOMMES-NOUS?';
ob_start();
require_once('../config/header.php');
?>

<main id="mainBoutique">
    <article id="PresentationContact">
        <section id="presentShop">
            <div id="titlePresentShop">
                <h2>JUNGLE GARDENER</h2>
                <h4>Deux passionnés à ton service.</h4>
            </div>

            <div id="paragraphPresent">
                <p><b>EMMA, LA GARDIENNE DES FICUS</b><br>
                    Après des années en tant que développeuse web à concevoir les rêves des autres, Emma a
                    décidé d’ébaucher le sien : élever des ficus, des philodendrons et des alocasias !
                    Forte d’une décennie à transformer son appartement en une véritable jungle, elle connaît
                    tous les aléas de la vie de jardinier urbain.
                </p>

                <p><b>NICOLAS, LE DOMPTEUR DE CACTUS</b><br>
                    Après avoir travaillé dans la neuroscience puis en tant que développeur web,
                    il préfère désormais se consacrer à la croissance des cactus plutôt qu’à la croissance
                    tout court. A l’écouter, les cactus sont comme lui… piquant.
                </p>
            </div>
        </section>

        <section id="formContact">
            <div id="NewContact">
                <p>CONTACT-NOUS !</p>
            </div>
            <div id="formMail">
                <?php if(isset($text)): ?>
                    <p class="succesMail">
                        Votre message à bien été envoyé.
                    </p>
                <?php endif; ?>
                <form id="formContactJungle" method="post" action="apropos.php">
                    <label for="nom">Votre Nom:</label>
                    <input type="text" name="nom" id="nom" placeholder="Votre nom de famille">

                    <label for="prenom">Votre prénom:</label>
                    <input type="text" name="prenom" id="prenom" placeholder="Votre prénom">

                    <label for="mail">Votre e-mail:</label>
                    <input type="email" name="mail" id="mail" placeholder="Votre@email.com">

                    <textarea name="message" placeholder="Votre message"></textarea>
                    <input class="buttonFilter" type="submit" value="ENVOYER" name="mailform"/>
                    <?php if (isset($error_msg)) : ?>
                        <p class="error_msg_shop">
                            <?= $error_msg; ?>
                        </p>
                    <?php endif; ?>
                </form>
            </div>
        </section>
    </article>
</main>

<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');

