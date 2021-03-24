<footer id="stickyFooter" class="page-footer">
  <div class="container">
    <div class="row">
      <div id="infosCompany" class="col l3 s3">
        <div id="logoResponsiveFooter"><img src="../images/imagessite/Capture1.PNG" id="logoFooter" alt="Logo Jungle Gardener"></div>
        <p id="textFooter" class="text-green darken-4"><strong>JUNGLE GARDENER</strong><br>8 RUE D'HOZIER<br>13002 MARSEILLE</p>
        <p class="text-green darken-4"><i class="fas fa-envelope-open-text"></i> contact@jungle.com</p>
        <p class="text-green darken-4"><i class="fas fa-phone-square"></i> 06 46 68 89 03</p>
      </div>
      <div id="SocialFooter" class="col l3 s6">
        <h5 class="titleFooter">NOUS CONTACTER</h5>
        <ul id="iconRow">
          <li><a class="text-green darken-4" href="#!"><i class="fab fa-facebook-square"></i></a></li>
          <li><a class="text-green darken-4" href="#!"><i class="fab fa-instagram-square"></i></a></li>
          <li><a class="text-green darken-4" href="#!"><i class="fab fa-twitter-square"></i></a></li>
        </ul>
      </div>
      <div id="MenuFooter" class="col l3 s9">
        <h5 class="titleFooter">MENU PRINCIPAL</h5>
        <ul>
          <li><a class="text-green darken-4" href="../Views/accueil.php">Home</a></li>
          <li><a class="text-green darken-4" href="../Views/boutique.php">Boutique</a></li>
          <li><a class="text-green darken-4" href="../Views/apropos.php">Qui somme nous ?</a></li>
        </ul>
      </div>
      <div id="PagesFooter" class="col l3 s12">
        <h5 class="titleFooter">ACCES</h5>
        <ul>
          <?php if (!isset($_SESSION['user']) || empty($_SESSION['user']->getEmail())) : ?>
            <li><a class="text-green darken-4" href="../Views/inscription.php">Inscription</a></li>
            <li><a class="text-green darken-4" href="../Views/connexion.php">Connexion</a></li>
          <?php elseif (isset($_SESSION['user']) && !empty($_SESSION['user']->getEmail())) : ?>
            <li><a class="text-green darken-4" href="../Views/moncompte.php">Mon compte</a></li>
            <li><a class="text-green darken-4" href="<?= $_SERVER['REQUEST_URI'] ?>?disconnect">Deconnexion</a></li>
            <?php if (isset($_SESSION) && !empty($_SESSION['user']->getEmail()) && $_SESSION['user']->getId_rights() == 42) : ?>
              <li><a class="text-green darken-4" href="../Views/admin.php">Admin</a></li>
            <?php endif; ?>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
</footer>
<script src="../js/Mate.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="../js/app.js"></script>