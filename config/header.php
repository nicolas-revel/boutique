<?php

$controlPanier = new \app\controllers\Controllerpanier();
$categoryDrop = new \app\views\components\viewHeader();
$searchBar = new \app\controllers\Controllerheader();
$ControlPanier = new \app\controllers\Controllerpanier();
?>

<header>
<ul id="dropdown1" class="dropdown-content">
    <?= $categoryDrop->showNameCategorie(); ?>
</ul>
<nav id="navBar">
    <div id="navBarUser">
        <ul class="right hide-on-med-and-down">
            <?php if(empty($_SESSION['user'])): ?>
                <li><a href="../inscription.php">QUI SOMMES-NOUS?</a></li>
                <li><a href="../inscription.php">INSCRIPTION</a></li>
                <li><a href="../Views/connexion.php">CONNEXION</a></li>
                <li><i class="fas fa-user"></i>HELLO YOU!</li>
            <?php elseif(!empty($_SESSION['user'])): ?>
                <li><a href="../inscription.php">QUI SOMMES-NOUS?</a></li>
                <li><a href="../Views/profil.php">MON COMPTE</a></li>
                <li><i class="fas fa-user"></i>HI <?= $_SESSION['user']->getEmail() ?></li>
            <?php else: ?>
                <li><a href="../Views/admin.php">ADMIN</a></li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="nav-wrapper">
        <a href="../Views/accueil.php" class="brand-logo"><div id="logoResponsive"><img src="../images/imagessite/logoJungle1.PNG" id="logoHeader" alt="Logo Jungle Gardener"></div></a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul id="navMenu" class="right hide-on-med-and-down">
            <li><a href="../Views/accueil.php">HOME</a></li>
            <li><a class="dropdown-trigger" href="#" data-target="dropdown1">BOUTIQUE<i class="material-icons right">arrow_drop_down</i></a></li>

            <!-- Affichage du prix total des produits dans le panier -->
            <?php if (!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false): ?>
                <?php if (isset($_SESSION['panier']) && !empty($_SESSION['panier']) && isset($_SESSION['user']) && !empty($_SESSION['user'])): ?>
                    <li id="liPanier"><a href="../Views/panier.php">PANIER (<?= number_format($ControlPanier->totalPrice(),2,',',' ') ?> €)</a></li>
                <?php else: ?>
                    <li id="liPanier"><a href="../Views/panier.php">PANIER (0,00 €)</a></li>
                <?php endif; ?>
            <?php endif; ?>

            <li>
                <form id="formSearch" method="get" action="../Views/boutique.php">
                    <div class="formNavBar">
                        <label class="label-icon" for="search"><i id="iconSearch" class="material-icons">search</i></label>
                        <input class="inputSearch" name="search" id="search" type="search" required>
                   </div>
                    <?php if(isset($_GET['search'])): ?>
                    <?php $searchBar->getSearchBar(); ?>
                    <?php endif; ?>
                </form>
           </li>
        </ul>
    </div>
</nav>
</header>
<ul class="sidenav" id="mobile-demo">
    <li><a href="../inscription.php">INSCRIPTION</a></li>
    <li><a href="../Views/connexion.php">CONNEXION</a></li>
    <li><a href="../Views/profil.php">MON COMPTE</a></li>
    <li><a href="../Views/admin.php">ADMIN</a></li>
    <li><a href="../Views/accueil.php">HOME</a></li>
    <li><a href="../Views/boutique.php">BOUTIQUE</a></li>
    <br>
    <li id="liPanier"><a href="../Views/panier.php">PANIER (Prix)</a></li>
</ul>
<div id="borderNav"></div>


<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
<script>
    $(document).ready(function(){
        // $('.parallax').parallax();
        $('.sidenav').sidenav();
        $('.modal').modal();
        $('.dropdown-trigger').dropdown({fullWidth: true});
    });

</script>
