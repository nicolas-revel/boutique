<?php
require_once('components/classesViewHeader.php');
require_once('components/classesViewPanier.php');
require_once '../vendor/autoload.php';

$contprofil = new \app\controllers\controllerprofil();
$viewPanier = new \app\views\components\viewPanier();
$controlPanier = new \app\controllers\Controllerpanier();
$modelPanier = new \app\models\Modelpanier();

if(isset($_GET['del'])){
    $modelPanier->delProductId($_GET['del']);
}
$pageTitle = 'PRODUIT';
ob_start();
require_once('../config/header.php');
?>

<main>

<div class="table">
    <div class="wrap">

        <div class="rowtitle">
            <span class="name">Product name</span>
            <span class="price">Price</span>
            <span class="quantity">Quantity</span>
            <span class="subtotal">Subtotal</span>
            <span class="action">Action</span>
        </div>
        <?php $ids = array_keys($_SESSION['panier']); ?>
        <?php if(empty($ids)){
            $products = array();
        }else{
            $products = $modelPanier->getProductById($ids);
        }
                foreach($products as $product): ?>
                    <div class="row">
                        <a href="#" class="img"><img src="../images/imageboutique/<?= $product->img_product ?>" height="65"></a>
                        <span class="name"><?= $product->name ?></span>
                        <span class="price"><?= number_format($product->price,2,',',' ') ?> €</span>
                        <span class="quantity"><?= $_SESSION['panier'][$product->id_product]; ?></span>
                        <span class="subtotal"><?= number_format($product->price * 1.196,2,',',' ') ?> €</span>
                        <span class="action">
                            <a href="panier.php?del=<?= $product->id_product ?>" class="del"><i class="fas fa-trash-alt"></i></a>
                        </span>
                    </div>
                <?php endforeach ?>
    </div>
</div>
</main>


<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
