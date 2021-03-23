<?php
require_once('components/classesViewHeader.php');
require_once('components/classesViewAccueil.php');
require_once '../vendor/autoload.php';

$showNewProduct = new \app\views\components\viewAccueil();
$controlAccueil = new \app\controllers\Controlleraccueil();

$pageTitle = 'ACCUEIL';
ob_start();
require_once('../config/header.php');
?>

    <main id="mainBoutique">
        <section id="confirmAddProduct">
            <div id='textConfirm'>
                <div id="textButtonError">
                    <p id="oops">OOP'S! JUNGLE 404<br>
                        <span id="nopage">Cette page ou ce produit n'existe pas.</span></p>
                    <div id='buttonBack2Shop'>
                        <a class="buttonFilter" href='boutique.php'>RETOUR SUR LE SITE</a>
                    </div>
                </div>
                <div id="gifImg">
                    <img id="gifAdd" src="../images/imagessite/error.gif" alt="animation confirmation ajout">
                </div>
            </div>
        </section>
    </main>

<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
