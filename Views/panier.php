<?php
require_once('components/classesViewHeader.php');
require_once('../app/Controllers/Controllerpanier.php');
require_once('components/classesViewPanier.php');
require_once '../vendor/autoload.php';
session_start();

$viewPanier = new \app\views\components\viewPanier();
$controlPanier = new \app\controllers\Controllerpanier();

$pageTitle = 'PRODUIT';
ob_start();
require_once('../config/header.php');
?>

<main>
    <a href="boutique.php">Continuez vos achats ></a>
    <?php if(!empty($_SESSION['panier'])){ var_dump($_SESSION['panier']);} ?>

        <table>
            <tr>
                <td><?php $viewPanier->showImagePanier(); ?></td>
                <td><?php $viewPanier->showNamePanier(); ?></td>
                <td><?php $viewPanier->showQuantityPanier(); ?></td>
                <td><?php $viewPanier->showPricePanier(); ?></td>
                <td><?php $viewPanier->showPriceTotalProductPanier(); ?></td>
                <?php if(isset($_POST['modifier'])){
                        $controlPanier->modifQuantityFromPanier ();
                        Header('Location: panier.php');} ?>
                <td><?php $viewPanier->showDeleteButton (); ?></td>
                <?php if(isset($_POST['delete'])){
                    $controlPanier->deleteFormProduct();
                    Header('Location: panier.php');} ?>
            </tr>
        </table>
    <?= $controlPanier->countPricePanier(); ?>
    <form action="panier.php" method='post'>
        <button type='submit' name='deletePanier'>Vider le panier</button></form>
    <?php if(isset($_POST['deletePanier'])){
        $controlPanier->getEmptyPanier();
        Header('Location: panier.php');} ?>

    <a href="panier.php?delivery=infos">Valider le panier</a>
</main>


<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
