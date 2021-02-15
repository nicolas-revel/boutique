<?php
require_once('components/classesViewHeader.php');
require_once('components/classesViewAccueil.php');
require_once '../vendor/autoload.php';

$showNewProduct = new \app\views\components\viewAccueil();
$controlComment = new \app\controllers\Controllerproduit();

$pageTitle = 'ACCUEIL';
ob_start();
require_once('../config/header.php');

?>

<main>
<h3>FORMULAIRE COMMENTAIRE</h3>
    <?php if(isset($_GET['product'])): ?>
    <div class="rating rating2"><!--
            --><a href="?product=<?= $_GET['product'] ?>&stars=5" title="Donner 5/5">★</a><!--
            --><a href="?product=<?= $_GET['product'] ?>&stars=4" title="Donner 4/5">★</a><!--
            --><a href="?product=<?= $_GET['product'] ?>&stars=3" title="Donner 3/5">★</a><!--
            --><a href="?product=<?= $_GET['product'] ?>&stars=2" title="Donner 2/5">★</a><!--
            --><a href="?product=<?= $_GET['product'] ?>&stars=1" title="Donner 1/5">★</a>
    </div>
    <br>
    <form action="produit.php?product=<?= $_GET['product'] ?>&stars=<?php if(isset($_GET['stars'])){ echo ''.$_GET['stars'].''; } ?>" method="post">
        <label for="commentProduct">Nom du produit :</label><br>
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
<?php endif; ?>
</main>

<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
