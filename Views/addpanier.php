<?php
require_once('components/classesViewHeader.php');
require_once('components/classesViewAccueil.php');
require_once('components/classesViewProduct.php');
require_once '../vendor/autoload.php';
$controlPanier = new \app\controllers\Controllerpanier();

$pageTitle = 'PRODUIT';
ob_start();
require_once('../config/header.php');
?>

    <main id="mainBoutique">
        <section id="confirmAddProduct">
            <?php if(isset($_GET['id'])): ?>
                <?php $product = $controlPanier->showAddPanier (); ?>
                   <?php if (isset($error_msg)) :?>
                        <p class='error_msg_shop'><?= $error_msg ?></p>
                    <?php endif; ?>
                        <div id='textConfirm'>
                            <div id="textButton">
                            <p class='flow-text' id="textAdd">Le produit à bien été ajouté à votre panier.</p>
                                <?php $controlPanier->add($product[0]->id_product); ?>
                                <div id='buttonConnect2'>
                                    <a id="lienBackShop" href='boutique.php'>< boutique</a>
                                    <a id="lienBackPanier"  href='panier.php'>Aller sur le panier ></a>
                                </div>
                            </div>
                            <div id="gifImg">
                                <img id="gifAdd" src="../images/imagessite/giphy.gif" alt="animation confirmation ajout">
                            </div>
                        </div>
                <?php endif; ?>
        </section>
    </main>


<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
