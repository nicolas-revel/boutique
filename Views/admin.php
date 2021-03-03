<?php
require_once('components/classesViewHeader.php');
require_once('components/classesViewBoutique.php');
require_once('../vendor/autoload.php');
session_start();

$contadmin = new \app\Controllers\Controlleradmin;
$view = new \app\views\components\ViewBoutique;

if (!isset($_GET['table'])) {
  $_GET['table'] = 'users';
  header('Location:admin.php?table=users');
}

if (isset($_POST['envoyer'])) {
  $controlAccueil->addCategory();
}



if ($_GET['table'] === 'users') {
  $users = $contadmin->getAllUsersById();
  $rights = $contadmin->getAllRights();
  if (isset($_POST['updrights'])) {
    $contadmin->updateUserRights($_POST['userid'], $_POST['rights']);
    header('Location:' . $_SERVER['REQUEST_URI']);
  }
  if (isset($_GET['del_user'])) {
    $contadmin->deleteUser($_GET['del_user']);
    header('Location:admin.php?table=users');
  }
}

if ($_GET['table'] === 'products') {
  $products = $contadmin->getAllProductsById();
  // var_dump($products);
  if (isset($_POST['add_product'])) {
    $controlAccueil->addProduct();
  }
}

if (isset($_GET['start']) && !empty($_GET['start'])) {
  $currentPage = (int) strip_tags($_GET['start']);
} else {
  $currentPage = 1;
}

$pageTitle = "ADMIN PANEL";
ob_start();
require_once('../config/header.php');
?>
<main>
  <aside>
    <nav>
      <ul>
        <li><a href="admin.php?table=users">Utilisateurs</a></li>
        <li><a href="admin.php?table=products">Produits</a></li>
        <li><a href="admin.php?table=orders">Commandes</a></li>
        <li><a href="admin.php?table=categories">Catégories</a></li>
        <li><a href="admin.php?table=subcategories">Sous-catégories</a></li>
      </ul>
    </nav>
  </aside>
  <?php if ($_GET['table'] === 'users') : ?>
    <h1>Dashboard : Utilisateurs</h1>
    <table>
      <thead>
        <tr>
          <th>Id Utilisateur</th>
          <th>Email</th>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Date de naissance</th>
          <th>Droits</th>
          <th>Modifier les droits</th>
          <th>Supprimer l'utilisateur</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user) : ?>
          <tr>
            <td><?= $user['id_user'] ?></td>
            <td><?= $user['email'] ?></td>
            <td><?= $user['firstname'] ?></td>
            <td><?= $user['lastname'] ?></td>
            <td><?= $user['birthdate'] ?></td>
            <td><?= $user['name_right'] ?></td>
            <td>
              <form method='post' action="">
                <select name='rights' id='rights'>
                  <option value=""></option>
                  <?php foreach ($rights as $right) : ?>
                    <option value="<?= $right['id_rights'] ?>"><?= $right['name_right'] ?></option>
                  <?php endforeach; ?>
                </select>
                <input type='text' id='userid' name='userid' value='<?= $user['id_user'] ?>' style='display: none'>
                <input type='submit' value='Maj Droits' id='submit' name='updrights'>
              </form>
            </td>
            <td><a href="<?= $_SERVER['REQUEST_URI'] ?>&del_user=<?= $user['id_user'] ?>">Supprimer cet utilisateur</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php elseif ($_GET['table'] === 'products') : ?>
    <?php $view->showPagination($_SERVER['REQUEST_URI'], null, $start = "?start=", $currentPage, $pages) ?>
    <h3>FORMULAIRE AJOUT PRODUITS</h3>
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
      <input type="submit" value="Ajouter le produit" name="add_product">
    </form>
  <?php elseif ($_GET['table'] === 'orders') : ?>

  <?php elseif ($_GET['table'] === 'categories') : ?>
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
    </form>
  <?php elseif ($_GET['table'] === 'subcategories') : ?>

  <?php endif; ?>
</main>
<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once("template.php");
