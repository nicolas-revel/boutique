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
        <h3>PRODUITS PHARES</h3>
        <?= $showNewProduct->TopProductView(); ?>

        <section id="showCategory">
            <?= $showNewProduct->showCategoryWithPictures(); ?>
        </section>
    </article>



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
    </script>


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

</main>

<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once('template.php');
