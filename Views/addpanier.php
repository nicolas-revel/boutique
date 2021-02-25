<?php
require_once('components/classesViewHeader.php');
require_once('components/classesViewAccueil.php');
require_once('components/classesViewProduct.php');
require_once '../vendor/autoload.php';
$modelPanier = new \app\models\Modelpanier();

if(isset($_GET['id'])){
    $product = $modelPanier->getProductIdBdd();
    if(empty($product)){
        die ("Ce produit n'existe pas!");
    }
    $modelPanier->add($product[0]->id_product);
    die('Le produit à bien été ajouté à votre panier <a href="boutique.php">Retourner sur la boutique</a>');

}else {
    die ("Vous n'avez pas sélectionné de produit à ajouter au panier");
}

$pageTitle = 'PRODUIT';
ob_start();
require_once('../config/header.php');
?>

<main></main>

<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
