<?php

use League\HTMLToMarkdown\HtmlConverter;

require_once('components/classesViewHeader.php');
require_once('components/classesViewAccueil.php');
require_once('components/classesViewProduct.php');
require_once('../src/Controllers/Controllerapropos.php');
require_once('components/classesViewBoutique.php');
require_once('components/classesViewPanier.php');
require_once '../vendor/autoload.php';

session_start();

$viewProduct = new \Views\components\viewProduct();
$controlComment = new \src\controllers\Controllerproduit();
$contprofil = new \src\controllers\controllerprofil();
$viewPanier = new \Views\components\viewPanier();
$contorderdetail = new \src\controllers\Controllerdetailorder;
$contprofil = new \src\controllers\controllerprofil();
$continsc = new \src\controllers\Controllerinscription();
$contconnexion = new \src\controllers\Controllerconnexion();
$viewProductShop = new \Views\components\viewBoutique();
$showNewProduct = new \Views\components\viewAccueil();
$controlAccueil = new \src\controllers\Controlleraccueil();
$contadmin = new \src\Controllers\Controlleradmin();
$controlPanier = new \src\controllers\Controllerpanier();
$controlContact = new \src\controllers\Controllerapropos();
$converter = new \League\HTMLToMarkdown\HtmlConverter();
