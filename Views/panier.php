<?php
require_once('components/classesViewHeader.php');
require_once('../app/Controllers/Controllerpanier.php');
require_once('components/classesViewPanier.php');
require_once '../vendor/autoload.php';
session_start();

$contprofil = new \app\controllers\controllerprofil();
$viewPanier = new \app\views\components\viewPanier();
$controlPanier = new \app\controllers\Controllerpanier();

if (isset($_GET['delivery']) && isset($_POST['add_new_adress'])) {
    try {
        $contprofil->insertAdress(1, $_POST['title'], $_POST['country'], $_POST['town'], $_POST['postal_code'], $_POST['street'], $_POST['infos'], $_POST['number']);
    } catch (\PDOException $e) {
        $error_msg = $e->getMessage();
    }
}

$pageTitle = 'PRODUIT';
ob_start();
require_once('../config/header.php');
?>

<main><?php if(isset($_SESSION['panier']) && !isset($_GET['delivery'])): ?>
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
    <?php endif; ?>

    <?php if(isset($_SESSION['panier']) && isset($_GET['delivery'])): ?>
        <?php if(!empty($_SESSION['panier'])){ var_dump($_SESSION['panier']);} ?>

    <div id="noConnect">
        <p>Pas encore inscrit? <a href="Inscription.php">Rejoins-nous</a></p>
        <p>Déjà membre? <a href="connexion.php">Connecte-toi</a></p>
    </div>

    <section id="modifFormAdress">
        <h2>Ajouter une nouvelle adresse d'expédition : </h2>
        <form action="moncompte.php" method="POST">
            <div class="form-item">
                <label for="title">Donnez un nom à cette adresse :</label>
                <input type="text" name="title" id="title" placeholder="ex : Appartement perso" required>
            </div>
            <div class="form-item">
                <label for="country">Pays :</label>
                <input type="text" name="country" id="country" placeholder="ex : France" required>
            </div>
            <div class="form-item">
                <label for="town">Ville :</label>
                <input type="text" name="town" id="town" placeholder="ex : Marseille" required>
            </div>
            <div class="form-item">
                <label for="postal_code">Code Postal :</label>
                <input type="text" name="postal_code" id="postal_code" placeholder="ex : 13001" required>
            </div>
            <div class="form-item">
                <label for="street">Rue :</label>
                <input type="text" name="street" id="street" placeholder="ex : Rue d'Hozier" required>
            </div>
            <div class="form-item">
                <label for="infos">Infos supplémentaires :</label>
                <input type="text" name="infos" id="infos" placeholder="ex : Appartement 8">
            </div>
            <div class="form-item">
                <label for="number">Numéro de rue :</label>
                <input type="number" name="number" id="number" spellcheck="true" required>
            </div>
            <input type="submit" value="Ajouter l'adresse" name="add_new_adress">
        </form>
    </section>
    <div id="redirection">
        <a href="panier.php">Retour panier</a>
    </div>
    <br>
        <table>
            <tr>
                <td><?php $viewPanier->showImagePanier(); ?></td>
                <td><?php $viewPanier->showNamePanier(); ?></td>
                <td><?php $viewPanier->showQuantityPanier(); ?></td>
                <td><?php $viewPanier->showPricePanier(); ?></td>
                <td><?php $viewPanier->showPriceTotalProductPanier(); ?></td>
            </tr>
        </table>

        <p>Sous-total: </p><?= $controlPanier->countPricePanier(); ?>
        <p>Total (taxe de 2,00€ incluse):</p><?= $controlPanier->countPricePanierWithTaxe (); ?>
        <br>
        <a href="panier.php?delivery=type">Expidition ></a>
    <?php endif; ?>
</main>


<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
