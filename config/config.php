<?php

use League\HTMLToMarkdown\HtmlConverter;

require_once('components/classesViewHeader.php');
require_once('components/classesViewAccueil.php');
require_once('components/classesViewProduct.php');
require_once('../app/Controllers/Controllerapropos.php');
require_once('components/classesViewBoutique.php');
require_once('components/classesViewPanier.php');
require_once '../vendor/autoload.php';

session_start();

$viewProduct = new \Views\components\viewProduct();
$controlComment = new \app\controllers\Controllerproduit();
$contprofil = new \app\controllers\controllerprofil();
$viewPanier = new \Views\components\viewPanier();
$contorderdetail = new \app\controllers\Controllerdetailorder;
$contprofil = new \app\controllers\controllerprofil();
$continsc = new \app\controllers\Controllerinscription();
$contconnexion = new \app\controllers\Controllerconnexion();
$viewProductShop = new \Views\components\viewBoutique();
$showNewProduct = new \Views\components\viewAccueil();
$controlAccueil = new \app\controllers\Controlleraccueil();
$contadmin = new \app\Controllers\Controlleradmin();
$controlPanier = new \app\controllers\Controllerpanier();
$controlContact = new \app\controllers\Controllerapropos();
$converter = new \League\HTMLToMarkdown\HtmlConverter();
