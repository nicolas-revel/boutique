<?php
require_once('../config/config.php');

use app\classes\product;

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

$categories = $contadmin->getAllCategories();
$subcategories = $contadmin->getAllSubcategories();

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
} elseif ($_GET['table'] === 'guests') {
  if (isset($_GET['del_guest'])) {
    $contadmin->deleteGuest($_GET['del_guest']);
    header('Location:admin.php?table=guests');
  }
  $guests = $contadmin->getAllGuests();
} elseif ($_GET['table'] === 'adresses') {
  if (isset($_GET['del_adress'])) {
    $contadmin->deleteAdress($_GET['del_adress']);
  }
  $adresses = $contadmin->getAllAdresses();
} elseif ($_GET['table'] === 'products') {
  if (isset($_POST['insert_prod'])) {
    $contadmin->insertProduct($_POST['name_product'], $_POST['description_product'], $_POST['price_product'], $_POST['subcategory_product'], $_POST['stocks_product'], $_FILES['image_product']);
  }
  if (isset($_POST['add_stocks'])) {
    $contadmin->addStocks($_POST['id_product'], $_POST['stocks']);
  }
  if (isset($_GET['modif_prod'])) {
    $update_prod = $contadmin->getProductById($_GET['modif_prod']);
    $markdown = $converter->convert($update_prod['description']);

    if (isset($_POST['update_prod'])) {
      $contadmin->updateProduct($update_prod['id_product'], $_POST['name_product'], $_POST['description_product'], $_POST['price_product'], $_POST['subcategory_product'], $_FILES['image_product']);
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
  }
  if (isset($_GET['del_subcat'])) {
    $contadmin->deleteSubCategory($_GET['del_subcat']);
    header('Location:admin.php?table=subcategories');
  }
  $categories = $contadmin->getAllCategories();
  $subcategories = $contadmin->getAllSubcategoriesOffset();
}

$products = $contadmin->getAllProductsById();

$pageTitle = "ADMIN PANEL";
ob_start();
require_once('../config/header.php');
?>
<main id="admin">
  <?php if (isset($_SESSION) && $_SESSION['user']->getId_rights() == 42) : ?>
    <nav id="navAdmin">
      <ul>
        <li><a href="admin.php?table=users">Utilisateurs</a></li>
        <li><a href="admin.php?table=guests">Invités</a></li>
        <li><a href="admin.php?table=adresses">Adresses</a></li>
        <li><a href="admin.php?table=products">Produits</a></li>
        <li><a href="admin.php?table=orders">Commandes</a></li>
        <li><a href="admin.php?table=categories">Catégories</a></li>
        <li><a href="admin.php?table=subcategories">Sous-catégories</a></li>
      </ul>
    </nav>
    <section id="admin-dashboard">
      <?php if (isset($errormsg)) : ?>
        <div>
          <p class="error_msg">
            <?= $errormsg; ?>
          </p>
        </div>
      <?php endif; ?>
      <?php if ($_GET['table'] === 'users') : ?>
        <h3>Dashboard : Utilisateurs</h3>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Email</th>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Date de naissance</th>
              <th>Droits</th>
              <th>Modifier les droits</th>
              <th>Supprimer l'utilisateur</th>
            </tr>
          </thead>
          <tbody id="users-tbody">
            <?php foreach ($users as $user) : ?>
              <tr>
                <td><?= $user['id_user'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['firstname'] ?></td>
                <td><?= $user['lastname'] ?></td>
                <td id="birthdate"><?= $user['birthdate'] ?></td>
                <td><?= $user['name_right'] ?></td>
                <td>
                  <form method='post' action="" class="form-table">
                    <select name='rights' id='rights'>
                      <option value=""></option>
                      <?php foreach ($rights as $right) : ?>
                        <option value="<?= $right['id_rights'] ?>"><?= $right['name_right'] ?></option>
                      <?php endforeach; ?>
                    </select>
                    <input type='text' id='userid' name='userid' value='<?= $user['id_user'] ?>' style='display: none'>
                    <button class="btn btn-small waves-effect waves-light orange darken-1" type="submit" name="updrights">Maj Droits</button>
                  </form>
                </td>
                <td class="cell-center"><a href="<?= $_SERVER['REQUEST_URI'] ?>&del_user=<?= $user['id_user'] ?>" class="link link-danger">Supprimer</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php elseif ($_GET['table'] === 'guests') : ?>
        <h3>Dashboard : Invités</h3>
        <table>
          <thead>
            <th class="cell-center">ID</th>
            <th class="cell-center">Email</th>
            <th class="cell-center">Nom</th>
            <th class="cell-center">Prénom</th>
            <th class="cell-center">Supprimer l'invité</th>
          </thead>
          <tbody>
            <?php foreach ($guests as $guest) : ?>
              <tr>
                <td><?= $guest->id_guest ?></td>
                <td><?= $guest->guest_mail ?></td>
                <td><?= $guest->guest_lastname ?></td>
                <td><?= $guest->guest_firstname ?></td>
                <td class="cell-center"><a href="<?= $_SERVER['REQUEST_URI'] ?>&del_guest=<?= $guest->id_guest ?>" class="link link-danger">Supprimer l'invité</a></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      <?php elseif ($_GET['table'] === 'adresses') : ?>
        <h3>Dashboard : Invités</h3>
        <table>
          <thead>
            <th class="cell-center">ID</th>
            <th class="cell-center">ID User</th>
            <th class="cell-center">ID Guest</th>
            <th class="cell-center">Pays</th>
            <th class="cell-center">Ville</th>
            <th class="cell-center">Code postal</th>
            <th class="cell-center">Rue</th>
            <th class="cell-center">Infos supplémentaires</th>
            <th class="cell-center">Numéro</th>
            <th class="cell-center">Supprimer l'adresse</th>
          </thead>
          <tbody>
            <?php foreach ($adresses as $adress) : ?>
              <tr>
                <td class="cell-center"><?= $adress['id_adress'] ?></td>
                <td class="cell-center"><?= $adress['id_user'] ?></td>
                <td class="cell-center"><?= $adress['id_guest'] ?></td>
                <td><?= $adress['country'] ?></td>
                <td><?= $adress['town'] ?></td>
                <td><?= $adress['postal_code'] ?></td>
                <td><?= $adress['street'] ?></td>
                <td><?= $adress['infos'] ?></td>
                <td><?= $adress['number'] ?></td>
                <td class="cell-center"><a href="<?= $_SERVER['REQUEST_URI'] ?>&del_adress=<?= $adress['id_adress'] ?>" class="link link-danger">Supprimer l'adresse</a></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      <?php elseif ($_GET['table'] === 'products') : ?>
        <h3>FORMULAIRE <?= (isset($_GET['modif_prod'])) ? 'MODIFICATION' : 'AJOUT' ?> PRODUITS</h3>
        <form action="" method="post" enctype="multipart/form-data" id="form-products">
          <div class="form-column">
            <div class="input-field">
              <label for="name_product">Nom du produit :</label>
              <input type="text" name="name_product" id="name_product" value="<?= (isset($_GET['modif_prod'])) ? $update_prod['name'] : '' ?>">
            </div>
            <div class="input-field">
              <textarea name="description_product" id="description_product" class="materialize-textarea"><?= (isset($_GET['modif_prod'])) ? "$markdown" : '' ?></textarea>
              <label for="description_product">Description du produit :</label>
            </div>
          </div>
          <div class="form-column">
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
              <div class="btn waves-effect waves-light orange darken-1">
                <span>Image du produit</span>
                <input type="file" name="image_product">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text" value="<?= (isset($_GET['modif_prod'])) ? $update_prod['img_product'] : '' ?>">
              </div>
            </div>
            <button class="btn waves-effect waves-light orange darken-1" type="submit" name="<?= (isset($_GET['modif_prod'])) ? 'update_prod' : 'insert_prod' ?>"><?= (isset($_GET['modif_prod'])) ? 'Modifier' : 'Ajouter' ?> le produit</button>
          </div>
        </form>
        <?php if (!isset($_GET['modif_prod'])) : ?>
          <h3>Dashboard : Produits</h3>
          <table>
            <thead>
              <tr>
                <th class="cell-center">ID</th>
                <th class="cell-center">Nom Produit</th>
                <th class="cell-center">Categorie</th>
                <th class="cell-center">Sous-categorie</th>
                <th class="cell-center">Prix</th>
                <th class="cell-center">Stocks</th>
                <th class="cell-center">Ajouter des stocks</th>
                <th class="cell-center">Modifier</th>
                <th class="cell-center">Supprimer</th>
              </tr>
            </thead>
            <tbody id="products-tbody">
              <?php foreach ($products as $product) : ?>
                <?php if ($product['product_availability'] != 2) : ?>
                  <tr>
                    <td><?= $product['id_product'] ?></td>
                    <td class="table_prod_name"><a href="produit.php?product=<?= $product['id_product'] ?>" target="_blank" class="link link-classic"><?= $product['name'] ?></a></td>
                    <td><?= $product['category_name'] ?></td>
                    <td><?= $product['subcategory_name'] ?></td>
                    <td class="cell-center"><?= $product['price'] ?></td>
                    <td class="cell-center"><?= $product['stocks'] ?></td>
                    <td class="table_prod_stock_form">
                      <form action="" method="post" class="form-table">
                        <div class="input-field">
                          <label for="stocks">Ajouter du stock</label>
                          <input type="number" name="stocks" id="stocks">
                        </div>
                        <input type='text' id='id_product' name='id_product' value='<?= $product['id_product'] ?>' style='display: none'>
                        <button class="btn waves-effect waves-light orange darken-1" type="submit" name="add_stocks">Ajouter</button>
                      </form>
                    </td>
                    <td class="cell-center"><a href="admin.php?table=products&modif_prod=<?= $product['id_product'] ?>" class="link link-warning">Modifer l'article</a></td>
                    <td class="cell-center"><a href="admin.php?table=products&del_prod=<?= $product['id_product'] ?>" class="link link-danger">Supprimer l'article</a></td>
                  </tr>
                <?php endif ?>
              <?php endforeach ?>
            </tbody>
          </table>
          <ul class="pagination">
            <li <?= $current_page <= 1 ? "class='disabled'" : '' ?>>
              <a <?= ($current_page > 1) ? "href='admin.php?table=products&page_nb=$previous_page'" : "" ?>><i class="material-icons">keyboard_arrow_left</i></a>
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
                  } ?>><i class="material-icons">keyboard_arrow_right</i></a>
            </li>
          </ul>
        <?php endif; ?>
      <?php elseif ($_GET['table'] === 'orders') : ?>
        <h3>Dashboard : Commandes</h3>
        <table>
          <thead>
            <tr>
              <th class="cell-center">ID</th>
              <th class="cell-center">Détail de la commande</th>
              <th class="cell-center">Date</th>
              <th class="cell-center">Total</th>
              <th class="cell-center">Status</th>
              <th class="cell-center">Modifier le status</th>
              <th class="cell-center">Supprimer</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orders as $order) : ?>
              <tr>
                <td><?= $order['id_order'] ?></td>
                <td><a href="orderdetail?id_order=<?= $order['id_order'] ?>" target="_blank" class="link link-classic">Détail de la commande <?= $order['id_order'] ?></a></td>
                <td class="cell-center"><?= $order['date_order'] ?></td>
                <td class="cell-center"><?= $order['total_amount'] ?> €</td>
                <td><?= $order['status'] ?></td>
                <td>
                  <form action="" method="POST" class="form-table">
                    <select name='status' id='status'>
                      <option value=""></option>
                      <?php foreach ($statuses as $status) : ?>
                        <option value="<?= $status['id_status'] ?>"><?= $status['name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                    <input type='text' id='id_order' name='id_order' value='<?= $order['id_order'] ?>' style='display: none'>
                    <button class="btn btn-small waves-effect waves-light orange darken-1" type="submit" name="updorder">Maj Status</button>
                  </form>
                </td>
                <td class="cell-center"><a href="<?= $_SERVER['REQUEST_URI'] ?>&delorder=<?= $order['id_order'] ?>" class="link link-danger">Supprimer la commande</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php elseif ($_GET['table'] === 'categories') : ?>
        <h3>FORMULAIRE CATEGORIES</h3>
        <form id="form-categories" action="" method="post" enctype="multipart/form-data">
          <div class="form-column">
            <div class="input-field">
              <label for="category_name">Nom de la categorie : </label>
              <input name="category_name" id="category_name" type="text">
            </div>
          </div>
          <div class="form-column">
            <div class="file-field input-field">
              <div class="btn waves-effect waves-light orange darken-1">
                <span>Image catégorie</span>
                <input type="file" name="category_img">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
              </div>
            </div>
            <button class="btn waves-effect waves-light orange darken-1" type="submit" name="insertcat">Envoyer</button>
          </div>
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
                <td><a href="<?= $_SERVER['REQUEST_URI'] ?>&del_cat=<?= $categorie['id_category'] ?>" class="link link-danger">Supprimer cette catégorie</a></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
        <?php if (isset($errormsg)) : ?>
          <p><?= $errormsg ?></p>
        <?php endif ?>
      <?php elseif ($_GET['table'] === 'subcategories') : ?>
        <h3>FORMULAIRE SOUS-CATEGORIES</h3>
        <form id="form-subcategories" action="" method="post">
          <div class="form-column">
            <div class="input-field">
              <label for="subcategory_name">Nom de la sous-categorie : </label>
              <input name="subcategory_name" id="subcategory_name" type="text">
            </div>
          </div>
          <div class="form-column">
            <div class="input-field">
              <label for="id_category">Catégorie - Sous-catégorie</label>
              <select name="id_category">
                <option value=""></option>
                <?php foreach ($categories as $category) : ?>
                  <option value="<?= $category['id_category'] ?>"><?= $category['category_name'] ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>
          <button class="btn waves-effect waves-light orange darken-1" type="submit" name="insert_subcat">Envoyer</button>
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
                <td><a href="<?= $_SERVER['REQUEST_URI'] ?>&del_subcat=<?= $subcategory['id_subcategory'] ?>" class="link link-danger">Supprimer cette sous-catégorie</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <ul class="pagination">
          <li <?= $current_page <= 1 ? "class='disabled'" : '' ?>>
            <a <?= ($current_page > 1) ? "href='admin.php?table=subcategories&page_nb=$previous_page'" : "" ?>><i class="material-icons">keyboard_arrow_left</i></a>
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
                } ?>><i class="material-icons">keyboard_arrow_right</i></a>
          </li>
        </ul>
      <?php endif; ?>
    </section>
  <?php else : ?>
    <div>
      <p class="error_msg">
        Oups, il semblerait que vous n'avez pas accès à cette page ! Vous allez être redirigé vers l'accueil.
      </p>
    </div>
    <?php header("refresh:2; url=accueil.php"); ?>
  <?php endif ?>
</main>
<?php
require_once('../config/footer.php');
$pageContent = ob_get_clean();

require_once("template.php");
