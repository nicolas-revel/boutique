<?php
$categoryDrop = new \app\views\components\viewHeader();
$searchBar = new \app\controllers\Controllerheader();
?>

<header>
<ul id="dropdown1" class="dropdown-content">
    <?= $categoryDrop->showNameCategorie(); ?>
</ul>
<nav id="navBar">
    <div id="navBarUser">
        <ul class="right hide-on-med-and-down">
            <li><a href="../inscription.php">INSCRIPTION</a></li>
            <li><a href="../Views/connexion.php">CONNEXION</a></li>
            <li><a href="../Views/profil.php">MON COMPTE</a></li>
            <li><a href="../Views/admin.php">ADMIN</a></li>
            <li><i class="fas fa-user"></i>HI USER!</li>
        </ul>
    </div>
    <div class="nav-wrapper">
        <a href="../Views/accueil.php" class="brand-logo"><div id="logoResponsive"><img src="../images/imagessite/logoJungle1.PNG" id="logoHeader" alt="Logo Jungle Gardener"></div></a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul id="navMenu" class="right hide-on-med-and-down">
            <li><a href="../Views/accueil.php">HOME</a></li>
            <li><a class="dropdown-trigger" href="#" data-target="dropdown1">BOUTIQUE<i class="material-icons right">arrow_drop_down</i></a></li>
            <li id="liPanier"><a href="../Views/panier.php">PANIER (Prix)</a></li>
            <li>
                <form id="formSearch" method="get" action="../Views/boutique.php">
                    <div class="formNavBar">
                        <label class="label-icon" for="search"><i id="iconSearch" class="material-icons">search</i></label>
                        <input class="inputSearch" name="search" id="search" type="search" required>
                   </div>
                    <?php if(isset($_GET['search'])): ?>
                    <?= $searchBar->getSearchBar($_GET['search']); ?>
                    <?php endif; ?>
                </form>
           </li>
        </ul>
    </div>
</nav>

<ul class="sidenav" id="mobile-demo">
    <li><a href="sass.html">Sass</a></li>
    <li><a href="badges.html">Components</a></li>
    <li><a href="collapsible.html">Javascript</a></li>
    <li><a href="mobile.html">Mobile</a></li>
</ul>
</header>
<div id="borderNav"></div>


<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
<script>
    $(document).ready(function(){
        // $('.parallax').parallax();
        $('.sidenav').sidenav();
        $('.modal').modal();
        $('.dropdown-trigger').dropdown();
    });

</script>
