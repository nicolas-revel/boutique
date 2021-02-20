<?php
require_once('components/classesViewHeader.php');
require_once('components/classesViewAccueil.php');
require_once('components/classesViewPanier.php');
require_once '../vendor/autoload.php';
session_start();

$viewPanier = new \app\views\components\viewPanier();

$pageTitle = 'PRODUIT';
ob_start();
require_once('../config/header.php');
?>

<main>
    <a href="boutique.php">Continuez vos achats ></a>
    <?php if(!empty($_SESSION['panier'])){ var_dump($_SESSION['panier']);} ?>

</main>


<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
