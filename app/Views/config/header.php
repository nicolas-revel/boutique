<?php
require_once('../components/classesViewHeader.php');
$categoryDrop = new viewHeader();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="../../../CSS/materialize.min.css"  media="screen,projection"/>
    <link rel="stylesheet" type="text/css" href="../../../CSS/boutique.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Header</title>
</head>
<body>


<ul id="dropdown1" class="dropdown-content">
    <?= $categoryDrop->showNameCategorie(); ?>

</ul>
<nav id="navBar">
    <div id="navBarUser">
        <ul class="right hide-on-med-and-down">
            <li><a href="../inscription.php">INSCRIPTION</a></li>
            <li><a href="../connexion.php">CONNEXION</a></li>
            <li><a href="../profil.php">MON COMPTE</a></li>
            <li><a href="../admin.php">ADMIN</a></li>
            <li><i class="fas fa-user"></i>HI USER!</li>
        </ul>
    </div>
    <div class="nav-wrapper">
        <a href="../accueil.php" class="brand-logo"><div id="logoResponsive"><img src="../../../images/imagessite/logoJungle1.PNG" id="logoHeader" alt="Logo Jungle Gardener"></div></a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul id="navMenu" class="right hide-on-med-and-down">
            <li><a href="../accueil.php">HOME</a></li>
            <li><a class="dropdown-trigger" href="#" data-target="dropdown1">BOUTIQUE<i class="material-icons right">arrow_drop_down</i></a></li>
            <li id="liPanier"><a href="../panier.php">PANIER (Prix)</a></li>
            <li>
                <form id="formSearch">
                    <div class="formNavBar">
                        <label class="label-icon" for="search"><i id="iconSearch" class="material-icons">search</i></label>
                        <input class="inputSearch" id="search" type="search" required>
                   </div>
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
<script type="text/javascript" src="../../../js/materialize.min.js"></script>

</body>
</html>