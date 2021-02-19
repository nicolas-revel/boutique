<?php
?>
<h3>FORMULAIRE CATEGORIES</h3>
    <form action="admin.php" method="post" enctype="multipart/form-data">
        <label for="categoryName">Nom de la categorie : </label>
        <input name="categoryName" id="categoryName" type="text">
        <div class="row">
            <div class="file-field input-field">
                <div class="btn">
                    <span>File</span>
                    <input type="file" name="fileimg">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
            </div>
        <input name="envoyer" type="submit" value="Envoyer" />
            <?php
            if (isset($_POST['envoyer']) )
            {
               $controlAccueil->addCategory();
            }


            ?>
    </form>

<h4>FORMULAIRE AJOUT PRODUITS</h4>

<form action="admin.php" method="post" enctype="multipart/form-data">
    <label for="nameProduct">Nom du produit :</label><br>
    <input type="text" name="nameProduct" id="nameProduct">
    <br>
    <label for="descriptionProduct">Description du produit :</label>
    <textarea name="descriptionProduct" id="descriptionProduct"></textarea>
    <br>
    <label for="priceProduct">Prix du produit :</label><br>
    <input type="text" name="priceProduct" id="priceProduct">
    <br>
    <div class="input-field col s12">
        <label>
            <select name="selectSubCat">
                <?= $showNewProduct->showSubCategoryOptionSelect(); ?>
            </select>
        </label>
    </div>
    <br>
    <div class="file-field input-field">
        <div class="btn">
            <span>File</span>
            <input type="file" name="fileimg">
        </div>
        <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
        </div>
    </div>
    <input type="submit" value="envoyer" name="envoyer">
    <?php
    if (isset($_POST['envoyer']) )
    {
        $controlAccueil->addProduct();
    }

    ?>
</form>