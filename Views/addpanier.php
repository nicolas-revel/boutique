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

<main>
    <?php
    if(isset($_GET['id'])) {
        $product = $controlPanier->getProductIdBdd();
        if (empty($product)) {
            die ("Ce produit n'existe pas!");
        }
        $controlPanier->add($product[0]->id_product);
        echo 'Le produit à bien été ajouté à votre panier <a href="boutique.php">Retourner sur la boutique</a><br><a href="panier.php">Aller sur le panier</a>';
    }
    ?>
</main>

<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
