<?php

namespace app\controllers;

class Controlleradmin extends \app\models\Modeladmin
{
  // Properties

  /**
   * total_product
   *
   * @var mixed
   */
  private $total_product;

  /**
   * prod_by_page
   *
   * @var mixed
   */
  private $prod_by_page;

  /**
   * offset
   *
   * @var mixed
   */
  private $offset;

  /**
   * total_pages
   *
   * @var mixed
   */
  private $total_pages;

  /**
   * Get total_product
   *
   * @return  mixed
   */
  public function getTotal_product()
  {
    return $this->total_product;
  }

  /**
   * Set total_product
   *
   * @param  mixed  $total_product  total_product
   *
   * @return  self
   */
  public function setTotal_product($total_product)
  {
    $this->total_product = $total_product;

    return $this;
  }

  /**
   * Get prod_by_page
   *
   * @return  mixed
   */
  public function getProd_by_page()
  {
    return $this->prod_by_page;
  }

  /**
   * Set prod_by_page
   *
   * @param  mixed  $prod_by_page  prod_by_page
   *
   * @return  self
   */
  public function setProd_by_page($prod_by_page)
  {
    $this->prod_by_page = $prod_by_page;

    return $this;
  }

  /**
   * Get offset
   *
   * @return  mixed
   */
  public function getOffset()
  {
    return $this->offset;
  }

  /**
   * Set offset
   *
   * @param  mixed  $offset  offset
   *
   * @return  self
   */
  public function setOffset($offset)
  {
    $this->offset = $offset;

    return $this;
  }

  /**
   * Get total_pages
   *
   * @return  mixed
   */
  public function getTotal_pages()
  {
    return $this->total_pages;
  }

  /**
   * Set total_pages
   *
   * @param  mixed  $total_pages  total_pages
   *
   * @return  self
   */
  public function setTotal_pages($total_pages)
  {
    $this->total_pages = $total_pages;

    return $this;
  }

  //Methods

  public function getAllRights()
  {
    return $this->getAllRightsDb();
  }

  /**
   * getAllUsersById
   *
   * @param  array $result
   * @return array
   */
  public function getAllUsersById()
  {
    return $this->getAllUserByIdDb();
  }

  /**
   * deleteUser
   *
   * @param  int $id_user
   * @return void
   */
  public function deleteUser(int $id_user)
  {
    $this->deleteUserDb($id_user);
  }

  /**
   * updateUserRights
   *
   * @param  int $id_user
   * @param  int $id_rights
   * @return void
   */
  public function updateUserRights($id_user, $id_rights)
  {
    $id_user = htmlspecialchars(trim(intval($id_user)));
    $id_rights = htmlspecialchars(trim(intval($id_rights)));
    $this->updateUserRightsDb($id_user, $id_rights);
  }

  /**
   * preparePagination
   *
   * @param  int $current_page
   * @return object
   */
  public function preparePagination($current_page)
  {
    $this->setProd_by_page(10);
    $this->setOffset(($current_page - 1) * $this->getProd_by_page());
    $this->setTotal_product($this->countProducts());
    $this->setTotal_pages(ceil($this->getTotal_product() / $this->getProd_by_page()));
    return $this;
  }

  /**
   * getAllProductsById
   *
   * @return ?array
   */
  public function getAllProductsById()
  {
    $offset = $this->getOffset();
    $prod_by_page = $this->getProd_by_page();
    return $this->getAllProductsByIdDb($offset, $prod_by_page);
  }

  /**
   * addStocks
   *
   * @param  int $id_product
   * @param  int $stocks
   * @return void
   */
  public function addStocks(int $id_product, int $stocks)
  {
    $this->addStocksDb($id_product, $stocks);
  }

  /**
   * getAllCategories
   *
   * @return array
   */
  public function getAllCategories()
  {
    return $this->getAllCategoriesDB();
  }

  public function getAllSubcategories () {
    return $this->getAllSubcategoriesDB();
  }

  /**
   * getAllSubcategoriesOffset
   *
   * @return array
   */
  public function getAllSubcategoriesOffset()
  {
    $offset = $this->getOffset();
    $prod_by_page = $this->getProd_by_page();
    return $this->getAllSubcategoriesOffsetDB($offset, $prod_by_page);
  }

  /**
   * insertProduct
   *
   * @param  string $product_name
   * @param  string $product_description
   * @param  string $product_price
   * @param  int $product_subcategory_id
   * @param  int $product_stocks
   * @param  array  $product_image
   * @return void
   */
  public function insertProduct($product_name, $product_description, $product_price, $product_subcategory_id, $product_stocks, $product_image)
  {
    if (empty($product_name) || empty($product_description) || empty($product_price) || empty($product_subcategory_id) || empty($product_stocks) || empty($product_image)) {
      throw new \Exception("Merci de bien remplir tous les champs obligatoires.");
    }
    if (!empty($product_image['name']) && $product_image['error'] !== 0) {
      throw new \Exception("Il y a eu une erreur lors de l'upload de votre avatar, merci de bien vouloir recommencer");
    }
    if ($product_image['size'] > 1000000) {
      throw new \Exception("Merci de choisir un fichier inférieur à 1 Go.");
    }
    if (!empty($product_image['name']) && $product_image['type'] !== 'image/png' && $product_image['type'] !== 'image/jpg' && $product_image['type'] !== 'image/jpeg') {
      throw new \Exception("Merci de choisir une image au format demandé.");
    }
    if (!empty($product_image['name'])) {
      $product_image_infos = pathinfo($product_image['name']);
      $extension_product_image = $product_image_infos['extension'];
      $product_image_name = md5(uniqid()) . '.' . $extension_product_image;
      move_uploaded_file($product_image['tmp_name'], "../images/imageboutique/$product_image_name");
    }
    $parser = new \Parsedown();
    $parser->setSafeMode(true);
    $product_name = htmlspecialchars(trim($product_name));
    $product_price = htmlspecialchars(trim($product_price));
    $product_stocks = htmlspecialchars(trim($product_stocks));
    $product_description = $parser->text($product_description);
    $this->insertProductDb($product_name, $product_description, $product_price, $product_subcategory_id, $product_stocks, $product_image_name);
  }

  /**
   * getProductById
   *
   * @param  int $id_product
   * @return void
   */
  public function getProductById($id_product)
  {
    $id_product = (int)htmlspecialchars(trim($id_product));
    return $this->getProductByIdDb($id_product);
  }

  /**
   * updateProduct
   *
   * @param  int $id_product
   * @param  string $product_name
   * @param  string $product_description
   * @param  string $product_price
   * @param  int $product_subcategory_id
   * @param  string $product_image
   * @return void
   */
  public function updateProduct($id_product, $product_name, $product_description, $product_price, $product_subcategory_id, $product_image)
  {
    $old_product = $this->getProductByIdDb($id_product);

    if (!empty($product_image['name'])) {
      $product_image_infos = pathinfo($product_image['name']);
      $extension_product_image = $product_image_infos['extension'];
      $product_image_name = md5(uniqid()) . '.' . $extension_product_image;
      move_uploaded_file($product_image['tmp_name'], "../images/imageboutique/$product_image_name");
    } else {
      $product_image_name = $old_product['img_product'];
    }
    $parser = new \Parsedown();
    $parser->setSafeMode(true);
    $product_name = htmlspecialchars(trim($product_name));
    $product_price = htmlspecialchars(trim($product_price));
    $product_description = $parser->text($product_description);
    $this->updateProductDb($id_product, $product_name, $product_description, $product_price, $product_subcategory_id, $product_image_name);
  }

  /**
   * deleteProduct
   *
   * @param  int $id_product
   * @return void
   */
  public function deleteProduct($id_product)
  {
    $id_product = (int)htmlspecialchars(trim($id_product));
    $this->deleteProductDb($id_product);
  }

  /**
   * getAllOrders
   *
   * @return void
   */
  public function getAllOrders()
  {
    $offset = $this->getOffset();
    $order_by_page = $this->getProd_by_page();
    return $this->getAllOrdersDb($offset, $order_by_page);
  }

  public function getAllStatus()
  {
    return $this->getAllStatusDb();
  }

  public function updateOrderStatus($id_order, $id_status)
  {
    $this->updateOrderStatusDB($id_order, $id_status);
  }

  public function deleteOrder($id_order)
  {
    $this->deleteOrderDb($id_order);
  }

  public function insertCategory($category_name, $img_category)
  {
    if (empty($category_name) && empty($img_category)) {
      throw new \Exception("Merci de bien remplir toutes les informations");
    }
    try {
      $category_name = htmlspecialchars(trim($category_name));
      $category_image_infos = pathinfo($img_category['name']);
      $extension_category_image = $category_image_infos['extension'];
      $category_image_name = md5(uniqid()) . '.' . $extension_category_image;
      move_uploaded_file($img_category['tmp_name'], "../images/imagecategory/$category_image_name");
      return $this->insertCategoryDb($category_name, $category_image_name);
    } catch (\Exception $e) {
      return $e;
    }
  }

  public function deleteCategory($id_category)
  {
    $this->deleteCategoryDb($id_category);
  }

  public function insertSubCategory($subcategory_name, $id_category)
  {
    if (empty($subcategory_name) && empty($id_category)) {
      throw new \Exception("Merci de bien remplir le formulaire dans son entrièreté");
    }
    try {
      $subcategory_name = htmlspecialchars(trim($subcategory_name));
      $id_category = (int)htmlspecialchars(trim($id_category));
      $this->insertSubCategoryDb($subcategory_name, $id_category);
    } catch (\Exception $e) {
      return $e;
    }
  }

  public function deleteSubCategory($id_subcategory)
  {
    $id_subcategory = (int)htmlspecialchars(trim($id_subcategory));
    $this->deleteSubCategoryDb($id_subcategory);
  }

  public function getAllGuests()
  {
    return $this->getGuestBdd();
  }

  public function deleteGuest($id_guest)
  {
    $id_guest = (int)htmlspecialchars(trim($id_guest));
    $this->deleteGuestDb($id_guest);
  }

  public function getAllAdresses()
  {
    return $this->getAllAdressesDb();
  }

  public function deleteAdress($id_adress)
  {
    $id_adress = (int)htmlspecialchars(trim($id_adress));
    $this->deleteAdressDb($id_adress);
  }
}
