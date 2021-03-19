<?php

use app\classes\product;

require_once('components/classesViewHeader.php');
require_once('../vendor/autoload.php');
session_start();

$contadmin = new \app\Controllers\Controlleradmin;

if (!isset($_GET['table'])) {
  $_GET['table'] = 'users';
  header('Location:admin.php?table=users');
}

if (isset($_GET['page_nb']) && $_GET['page_nb'] != "") {
  $current_page = (int)$_GET['page_nb'];
} else {
  $current_page = 1;
}
$next_page = $current_page + 1;
$previous_page = $current_page - 1;
$pagination = $contadmin->preparePagination($current_page);

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
} elseif ($_GET['table'] === 'products') {
  if (isset($_POST['insert_prod'])) {
    $contadmin->insertProduct($_POST['name_product'], $_POST['description_product'], $_POST['price_product'], $_POST['subcategory_product'], $_POST['stocks_product'], $_FILES['image_product']);
  }
  if (isset($_POST['add_stocks'])) {
    $contadmin->addStocks($_POST['id_product'], $_POST['stocks']);
  }
  if (isset($_GET['modif_prod'])) {
    $update_prod = $contadmin->getProductById($_GET['modif_prod']);
    if (isset($_POST['update_prod'])) {
      $contadmin->updateProduct($update_prod['id_product'], $_POST['name_product'], $_POST['description_product'], $_POST['price_product'], $_POST['subcategory_product'], $_FILES['img_product']);
      header('Location:admin.php?table=products');
    }
  }
  if (isset($_GET['del_prod'])) {
    $contadmin->deleteProduct($_GET['del_prod']);
    header('Location:admin.php?table=products');
  }
} elseif ($_GET['table'] === 'orders') {
  if (isset($_POST['updorder'])) {
    $contadmin->updateOrderStatus($_POST['id_order'], $_POST['status']);
  }
  if (isset($_GET['delorder'])) {
    $contadmin->deleteOrder($_GET['delorder']);
    header('Location:admin.php?table=orders');
  }
  $orders = $contadmin->getAllOrders();
  $statuses = $contadmin->getAllStatus();
} elseif ($_GET['table'] === "categories") {
  if (isset($_POST['insertcat'])) {
    try {
      $contadmin->insertCategory($_POST['category_name'], $_FILES['category_img']);
    } catch (\Exception $e) {
      $errormsg = $e->getMessage();
    }
  }
  if (isset($_GET['del_cat'])) {
    $contadmin->deleteCategory($_GET['del_cat']);
    header('Location:admin.php?table=categories');
  }
  $categories = $contadmin->getAllCategories();
} elseif ($_GET['table'] === 'subcategories') {
  if (isset($_POST['insert_subcat'])) {
    try {
      $contadmin->insertSubCategory($_POST['subcategory_name'], $_POST['id_category']);
    } catch (\Exception $e) {
      $errormsg = $e->getMessage();
    }
    var_dump($_POST);
  }
  if (isset($_GET['del_subcat'])) {
    $contadmin->deleteSubCategory($_GET['del_subcat']);
    header('Location:admin.php?table=subcategories');
  }
  $categories = $contadmin->getAllCategories();
  $subcategories = $contadmin->getAllSubcategories();
}



$categories = $contadmin->getAllCategories();
$subcategories = $contadmin->getAllSubcategories();
$products = $contadmin->getAllProductsById();

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
  <?php if (isset($errormsg)) : ?>
    <div>
      <p class="error_msg">
        <?= $errormsg; ?>
      </p>
    </div>
  <?php endif; ?>
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
    <h3>FORMULAIRE <?= (isset($_GET['modif_prod'])) ? 'MODIFICATION' : 'AJOUT' ?> PRODUITS</h3>
    <form action="" method="post" enctype="multipart/form-data">
      <div class="input-field">
        <label for="name_product">Nom du produit :</label>
        <input type="text" name="name_product" id="name_product" value="<?= (isset($_GET['modif_prod'])) ? $update_prod['name'] : '' ?>">
      </div>
      <div class="input-field">
        <textarea name="description_product" id="description_product" class="materialize-textarea"><?= (isset($_GET['modif_prod'])) ? "{$update_prod['description']}" : '' ?></textarea>
        <label for="description_product">Description du produit :</label>
      </div>
      <div class="input-field">
        <label for="price_product">Prix du produit :</label>
        <input type="text" name="price_product" id="price_product" value="<?= (isset($_GET['modif_prod'])) ? $update_prod['price'] : '' ?>">
      </div>
      <div class="input-field">
        <select name="subcategory_product">
          <option value=""></option>
          <?php foreach ($subcategories as $subcategory) : ?>
            <option value="<?= $subcategory['id_subcategory'] ?>" <?= (isset($update_prod) && $update_prod['id_subcategory'] == $subcategory['id_subcategory']) ? 'selected' : '' ?>><?= $subcategory['category_name'] ?> - <?= $subcategory['subcategory_name'] ?></option>
          <?php endforeach ?>
        </select>
        <label for="subcategory_product">Catégorie - Sous-catégorie</label>
      </div>
      <?php if (!isset($_GET['modif_prod'])) : ?>
        <div class="input-field">
          <label for="stocks_product">Définir les stocks</label>
          <input type="number" name="stocks_product" id="stocks_product">
        </div>
      <?php endif; ?>
      <div class="file-field input-field">
        <div class="btn">
          <span>Image du produit</span>
          <input type="file" name="image_product">
        </div>
        <div class="file-path-wrapper">
          <input class="file-path validate" type="text" value="<?= (isset($_GET['modif_prod'])) ? $update_prod['img_product'] : '' ?>">
        </div>
      </div>
      <button class="btn waves-effect waves-light" type="submit" name="<?= (isset($_GET['modif_prod'])) ? 'update_prod' : 'insert_prod' ?>"><?= (isset($_GET['modif_prod'])) ? 'Modifier' : 'Ajouter' ?> le produit</button>
    </form>
    <?php if (!isset($_GET['modif_prod'])) : ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nom Produit</th>
            <th>Categorie</th>
            <th>Sous-categorie</th>
            <th>Prix</th>
            <th>Stocks</th>
            <th>Ajouter des stocks</th>
            <th>Modifier</th>
            <th>Supprimer</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $product) : ?>
            <tr>
              <td><?= $product['id_product'] ?></td>
              <td class="table_prod_name"><a href="produit.php?product=<?= $product['id_product'] ?>" target="_blank"><?= $product['name'] ?></a></td>
              <td><?= $product['category_name'] ?></td>
              <td><?= $product['subcategory_name'] ?></td>
              <td><?= $product['price'] ?></td>
              <td><?= $product['stocks'] ?></td>
              <td class="table_prod_stock_form">
                <form action="" method="post">
                  <div class="input-field">
                    <label for="stocks">Ajouter du stock</label>
                    <input type="number" name="stocks" id="stocks">
                  </div>
                  <input type='text' id='id_product' name='id_product' value='<?= $product['id_product'] ?>' style='display: none'>
                  <button class="btn waves-effect waves-light orange darken-1" type="submit" name="add_stocks">Ajouter</button>
                </form>
              </td>
              <td><a href="admin.php?table=products&modif_prod=<?= $product['id_product'] ?>">Modifer l'article</a></td>
              <td><a href="admin.php?table=products&del_prod=<?= $product['id_product'] ?>">Supprimer l'article</a></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
      <ul class="pagination">
        <li <?= $current_page <= 1 ? "class='disabled'" : '' ?>>
          <a <?= ($current_page > 1) ? "href='admin.php?table=products&page_nb=$previous_page'" : "" ?>>Previous</a>
        </li>
        <?php if ($pagination->getTotal_pages() <= 10) : ?>
          <?php for ($counter = 1; $counter <= $pagination->getTotal_pages(); $counter++) : ?>
            <?php if ($counter == $current_page) : ?>
              <li class='active'><a><?= $counter ?></a></li>
            <?php else : ?>
              <li><a href='admin.php?table=products&page_nb=<?= $counter ?>'><?= $counter ?></a></li>
            <?php endif ?>
          <?php endfor ?>
        <?php endif ?>
        <li <?php if ($current_page >= $pagination->getTotal_pages()) {
              echo "class='disabled'";
            } ?>>
          <a <?php if ($current_page < $pagination->getTotal_pages()) {
                echo "href='admin.php?table=products&page_nb=$next_page'";
              } ?>>Next</a>
        </li>
      </ul>
    <?php endif; ?>
  <?php elseif ($_GET['table'] === 'orders') : ?>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Détail de la commande</th>
          <th>Date</th>
          <th>Total</th>
          <th>Status</th>
          <th>Modifier le status</th>
          <th>Supprimer</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $order) : ?>
          <tr>
            <td><?= $order['id_order'] ?></td>
            <td><a href="orderdetail?id_order=<?= $order['id_order'] ?>" target="_blank">Détail de la commande <?= $order['id_order'] ?></a></td>
            <td><?= $order['date_order'] ?></td>
            <td><?= $order['total_amount'] ?> €</td>
            <td><?= $order['status'] ?></td>
            <td>
              <form action="" method="POST">
                <select name='status' id='status'>
                  <option value=""></option>
                  <?php foreach ($statuses as $status) : ?>
                    <option value="<?= $status['id_status'] ?>"><?= $status['name'] ?></option>
                  <?php endforeach; ?>
                </select>
                <input type='text' id='id_order' name='id_order' value='<?= $order['id_order'] ?>' style='display: none'>
                <input type='submit' value='Maj Status' id='submit' name='updorder'>
              </form>
            </td>
            <td><a href="<?= $_SERVER['REQUEST_URI'] ?>&delorder=<?= $order['id_order'] ?>">Supprimer la commande</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <!-- <ul class="pagination">
      <li <?= $current_page <= 1 ? "class='disabled'" : '' ?>>
        <a <?= ($current_page > 1) ? "href='admin.php?table=orders&page_nb=$previous_page'" : "" ?>>Previous</a>
      </li>
      <?php if ($pagination->getTotal_pages() <= 10) : ?>
        <?php for ($counter = 1; $counter <= $pagination->getTotal_pages(); $counter++) : ?>
          <?php if ($counter == $current_page) : ?>
            <li class='active'><a><?= $counter ?></a></li>
          <?php else : ?>
            <li><a href='admin.php?table=orders&page_nb=<?= $counter ?>'><?= $counter ?></a></li>
          <?php endif ?>
        <?php endfor ?>
      <?php endif ?>
      <li <?php if ($current_page >= $pagination->getTotal_pages()) {
            echo "class='disabled'";
          } ?>>
        <a <?php if ($current_page < $pagination->getTotal_pages()) {
              echo "href='admin.php?table=orders&page_nb=$next_page'";
            } ?>>Next</a>
      </li>
    </ul> -->
  <?php elseif ($_GET['table'] === 'categories') : ?>
    <h3>FORMULAIRE CATEGORIES</h3>
    <form action="" method="post" enctype="multipart/form-data">
      <div class="input-field">
        <label for="category_name">Nom de la categorie : </label>
        <input name="category_name" id="category_name" type="text">
      </div>
      <div class="row">
        <div class="file-field input-field">
          <div class="btn">
            <span>Image catégorie</span>
            <input type="file" name="category_img">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
          </div>
        </div>
        <input name="insertcat" type="submit" value="Envoyer" />
    </form>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nom de la catégorie</th>
          <th>Image</th>
          <th>Supprimer</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($categories as $categorie) : ?>
          <tr>
            <td><?= $categorie['id_category'] ?></td>
            <td><?= $categorie['category_name'] ?></td>
            <td><img src="../images/imagecategory/<?= $categorie['img_category'] ?>" alt="" style="height: 3em;"></td>
            <td><a href="<?= $_SERVER['REQUEST_URI'] ?>&del_cat=<?= $categorie['id_category'] ?>">Supprimer cette catégorie</a></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    <?php if (isset($errormsg)) : ?>
      <p><?= $errormsg ?></p>
    <?php endif ?>
  <?php elseif ($_GET['table'] === 'subcategories') : ?>
    <h3>FORMULAIRE SOUS-CATEGORIES</h3>
    <form action="" method="post">
      <div class="input-field">
        <label for="subcategory_name">Nom de la sous-categorie : </label>
        <input name="subcategory_name" id="subcategory_name" type="text">
      </div>
      <div class="input-field">
        <label for="id_category">Catégorie - Sous-catégorie</label>
        <select name="id_category">
          <option value=""></option>
          <?php foreach ($categories as $category) : ?>
            <option value="<?= $category['id_category'] ?>"><?= $category['category_name'] ?></option>
          <?php endforeach ?>
        </select>
      </div>
      <input name="insert_subcat" type="submit" value="Envoyer" />
    </form>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Sous-categorie</th>
          <th>Categorie</th>
          <th>Supprimer</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($subcategories as $subcategory) : ?>
          <tr>
            <td><?= $subcategory['id_subcategory'] ?></td>
            <td><?= $subcategory['subcategory_name'] ?></td>
            <td><?= $subcategory['category_name'] ?></td>
            <td><a href="<?= $_SERVER['REQUEST_URI'] ?>&del_subcat=<?= $subcategory['id_subcategory'] ?>">Supprimer cette sous-catégorie</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <ul class="pagination">
      <li <?= $current_page <= 1 ? "class='disabled'" : '' ?>>
        <a <?= ($current_page > 1) ? "href='admin.php?table=subcategories&page_nb=$previous_page'" : "" ?>>Previous</a>
      </li>
      <?php if ($pagination->getTotal_pages() <= 10) : ?>
        <?php for ($counter = 1; $counter <= $pagination->getTotal_pages(); $counter++) : ?>
          <?php if ($counter == $current_page) : ?>
            <li class='active'><a><?= $counter ?></a></li>
          <?php else : ?>
            <li><a href='admin.php?table=subcategories&page_nb=<?= $counter ?>'><?= $counter ?></a></li>
          <?php endif ?>
        <?php endfor ?>
      <?php endif ?>
      <li <?php if ($current_page >= $pagination->getTotal_pages()) {
            echo "class='disabled'";
          } ?>>
        <a <?php if ($current_page < $pagination->getTotal_pages()) {
              echo "href='admin.php?table=subcategories&page_nb=$next_page'";
            } ?>>Next</a>
      </li>
    </ul>
  <?php endif; ?>
</main>
<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once("template.php");
