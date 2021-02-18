<?php
require_once('components/classesViewHeader.php');
require_once('components/classesViewAccueil.php');
require_once('components/classesViewProduct.php');
require_once '../vendor/autoload.php';
session_start();

$viewProduct = new \app\views\components\viewProduct();
$controlComment = new \app\controllers\Controllerproduit();

$pageTitle = 'PRODUIT';
ob_start();
require_once('../config/header.php');
?>

<?php if(isset($_GET['product'])): ?>
<main>

    <article id="detailProduct">

    <section id="imgProduct">
        <?= $viewProduct->showImageProduct(); ?>

        <form action="produit.php?product=<?= $_GET['product'] ?>" method="post">
            <label for="quantity">Quantité:</label>
            <input type="number" id="quantity" name="quantity" min="1">
            <input type="submit" name="panier" value="AJOUTER AU PANIER">
            <?php if (isset($_POST['panier'])) {
            $controlComment->TraitmentFormPanier(1);
            } ?>
        </form>
        <?php if(!empty($_SESSION['panier'])){ var_dump($_SESSION['panier']);} ?>

    </section>

    <section id="descriptionProduct">
        <?= $viewProduct->showInfosProduct(); ?>

        <br>
    <h6>FORMULAIRE COMMENTAIRE</h6>
    <div class="rating rating2"><!--
            --><a href="?product=<?= $_GET['product'] ?>&stars=5" title="Donner 5/5">★</a><!--
            --><a href="?product=<?= $_GET['product'] ?>&stars=4" title="Donner 4/5">★</a><!--
            --><a href="?product=<?= $_GET['product'] ?>&stars=3" title="Donner 3/5">★</a><!--
            --><a href="?product=<?= $_GET['product'] ?>&stars=2" title="Donner 2/5">★</a><!--
            --><a href="?product=<?= $_GET['product'] ?>&stars=1" title="Donner 1/5">★</a>
    </div>
    <br>
    <form action="produit.php?product=<?= $_GET['product'] ?>&stars=<?php if(isset($_GET['stars'])){ echo ''.$_GET['stars'].''; } ?>" method="post">
        <label for="commentProduct">Commentaire :</label><br>
        <input type="text" name="commentProduct" id="commentProduct">
        <br>
        <input type="submit" value="envoyer" name="envoyer">
        <?php
        if(isset($_POST['envoyer'])){
            $controlComment->addComment(1);
            Header('Location: produit.php?product='.$_GET['product'].'');
        }
        ?>
    </form>
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
