<?php
require_once('components/classesViewHeader.php');
require_once('../vendor/autoload.php');

session_start();


$pageTitle = "DETAIL COMMANDE ";
ob_start();
require_once('../config/header.php');
?>
<main id="orderdetail">

</main>
<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
