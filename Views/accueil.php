<?php
require_once('components/classesViewHeader.php');
require_once('components/classesViewAccueil.php');
require_once '../vendor/autoload.php';

$showNewProduct = new \app\views\components\viewAccueil();
$controlAccueil = new \app\controllers\Controlleraccueil();

$pageTitle = 'ACCUEIL';
ob_start();
require_once('../config/header.php');

?>

<main>
    <!-- Carousel nouveaux produits/ Ateliers terrarium -->
    <section id="containerCarousel">
    <div class="carousel carousel-slider" id="demo-carousel-auto" data-indicators="true" >
        <div class="carousel-item" id="carouselPictures1">
            <div class="carousel-fixed-item center" id="btnFirst">
                <a class="btn waves-effect transparent white-text green darken-text-4 share-btn" href="http://google.com" target="_blank">DECOUVRIR</a>
            </div>
        </div>
        <div class="carousel-item" id="carouselPictures2">
            <div class="carousel-fixed-item center" id="btnSecond">
                <a class="btn waves-effect transparent white-text green darken-text-4 share-btn" href="http://google.com" target="_blank">DECOUVRIR</a>
            </div>
        </div>
    </div>
    </section>

    <article>


        <h3 id="titleAccueil">NOS PRODUITS PHARES</h3>
        <section id="showTopProduct">
        <?= $showNewProduct->TopProductView(); ?>
        </section>

        <h3 id="titleAccueilCategorie">CATEGORIES</h3>
        <section id="showCategory">
            <?= $showNewProduct->showCategoryWithPictures(); ?>
        </section>
    </article>

    <h4>FORMULAIRE AJOUT PRODUITS</h4>

    <form action="accueil.php" method="post" enctype="multipart/form-data">
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


    <script>
        $(document).ready(function(){

            $('#demo-carousel-auto').carousel({fullWidth: true});
            $('.linkCarousel').click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                $('.carousel').carousel('DECOUVRIR')
            });

            setInterval(function() {

                $('#demo-carousel-auto').carousel('next');

            }, 5000);

            $('.share-btn').click(function (e) {
                var win = window.open('http://google.com', '_blank');
                win.focus();
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('select');
            var instances = M.FormSelect.init(elems, options);
        });

        // Or with jQuery

        $(document).ready(function(){
            $('select').formSelect();
        });
    </script>

</main>

<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
