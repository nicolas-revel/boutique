<?php
require_once('components/classesViewHeader.php');


$pageTitle = 'ACCUEIL';
ob_start();
require_once('../../config/header.php');




require_once('../../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
