<?php
?>
<h3>FORMULAIRE CATEGORIES</h3>
    <form action="accueil.php" method="post" enctype="multipart/form-data">
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
