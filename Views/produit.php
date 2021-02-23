<?php
require_once('components/classesViewHeader.php');
require_once('components/classesViewAccueil.php');
require_once('components/classesViewProduct.php');
require_once '../vendor/autoload.php';
session_start();

$pageTitle = 'PRODUIT';
ob_start();
require_once('../config/header.php');

$viewProduct = new \app\views\components\viewProduct();
$controlComment = new \app\controllers\Controllerproduit();

if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
    $id_user = $_SESSION['user']->getId_user();
    var_dump($id_user);
}

?>

<?php if(isset($_GET['product'])): ?>
<main>

    <article id="detailProduct">

    <section id="imgProduct">
        <?= $viewProduct->showImageProduct($_GET['product']); ?>

        <form action="produit.php?product=<?= $_GET['product'] ?>" method="post">
            <label for="quantity">Quantité:</label>
            <input type="number" id="quantity" name="quantity" min="1" value="1">
            <input type='submit' name='panier' value='AJOUTER AU PANIER'>
            <?php if(isset($_POST['panier']) && isset($_SESSION['user']) && !empty($_SESSION['user'])) {
            $controlComment->TraitmentFormPanier($id_user);
            Header('Location: panier.php');
            }?>

        </form>

    </section>

    <section id="descriptionProduct">
        <?= $viewProduct->showInfosProduct($_GET['product']); ?>

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
        if(isset($_POST['envoyer']) && isset($_SESSION['user']) && !empty($_SESSION['user'])){
            $controlComment->addComment($id_user);
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
