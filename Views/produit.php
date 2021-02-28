<?php
require_once('components/classesViewHeader.php');
require_once('components/classesViewAccueil.php');
require_once('components/classesViewProduct.php');
require_once '../vendor/autoload.php';

$viewProduct = new \app\views\components\viewProduct();
$controlComment = new \app\controllers\Controllerproduit();

if(isset($_SESSION['user']) && !empty($_SESSION['user'])){ $id_user = $_SESSION['user']->getId_user();}

//Traitement formulaire commentaire.
if(isset($_POST['envoyer']) && isset($_SESSION['user']) && !empty($_SESSION['user'])){
    try{
        $controlComment->addComment($id_user);
        Header('Location: produit.php?product='.$_GET['product'].'');
    }catch (\Exception $e) {
        $error_msg = $e->getMessage();
    }
}

$pageTitle = 'PRODUIT';
ob_start();
require_once('../config/header.php');
?>

<?php if(isset($_GET['product'])): ?>
<main id="mainBoutique">
    <article id="detailProduct">

    <section id="imgProduct">
        <?= $viewProduct->showImageProduct($_GET['product']); ?>
    </section>

    <section id="showDescriptionProduct">
        <?= $viewProduct->showInfosProduct($_GET['product']); ?>
        <br>
        <?= $viewProduct->showButtonPanier ($_GET['product']); ?>

            <div id="textShareExperience">
                <h6 id="titleShareExperience" class="flow-text">TON AVIS COMPTE POUR NOUS !</h6>
                <p id="textShare" class="flow-text">N'hésites pas à partager ton expérience Jungle Gardener avec les autres internautes, afin que nous puissions améliorer nos services pour vous.</p>
            </div>

        <div id="formComment">
            <div class="rating rating2"><!--
            --><a href="?product=<?= $_GET['product'] ?>&stars=5" title="Donner 5/5">★</a><!--
            --><a href="?product=<?= $_GET['product'] ?>&stars=4" title="Donner 4/5">★</a><!--
            --><a href="?product=<?= $_GET['product'] ?>&stars=3" title="Donner 3/5">★</a><!--
            --><a href="?product=<?= $_GET['product'] ?>&stars=2" title="Donner 2/5">★</a><!--
            --><a href="?product=<?= $_GET['product'] ?>&stars=1" title="Donner 1/5">★</a>
        </div>
    <br>
    <form action="produit.php?product=<?= $_GET['product'] ?>&stars=<?php if(isset($_GET['stars'])){ echo ''.$_GET['stars'].''; } ?>" method="post">
        <label for="commentProduct">Note :</label><br>
        <input type="text" name="commentProduct" id="commentProduct" placeholder="Commentaire">
        <br>
        <input type="submit" value="Envoyer" name="envoyer">
        <?php if (isset($error_msg)) : ?>
                <p class="error_msg_shop">
                    <?= $error_msg; ?>
                </p>
        <?php endif; ?>
    </form>
        </div>
    </section>
    </article>

    <section id="showCommentProduct">
        <?= $viewProduct->showCommentProduct(); ?>
    </section>

</main>
<?php endif; ?>
<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
