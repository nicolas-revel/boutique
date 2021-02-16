<?php

require_once('components/classesViewHeader.php');
require_once('components/classesViewBoutique.php');
require_once '../vendor/autoload.php';

$topProduct = new \app\views\components\viewBoutique();

$pageTitle = 'BOUTIQUE';
ob_start();
require_once('../config/header.php');

?>

<main>
    <article id="shopPage">
    <section id="filters"></section>

    <section id="showShop">
            <?= $topProduct->newProductView(); ?>
        <div class="separator"></div>
    </section>
    </article>
</main>





<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');



