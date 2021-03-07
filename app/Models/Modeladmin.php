<?php

namespace app\models;

class Modeladmin extends model
{
  /**
   * getAllUserByIdDb
   *
   * @return array
   */
  protected function getAllUserByIdDb()
  {
    $pdo = $this->getBdd();
    $querystring =
      "SELECT id_user, email, firstname, lastname, users.id_rights, birthdate, rights.name_right
      FROM users
      INNER JOIN rights
      ON users.id_rights = rights.id_rights
      ORDER BY id_user";
    $query = $pdo->query($querystring);
    $result = $query->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * deleteUserDb
   *
   * @param  int $id_user
   * @return void
   */
  protected function deleteUserDb(int $id_user)
  {
    $pdo = $this->getBdd();
    $querystring =
      "DELETE FROM users
      WHERE id_user = :id_user";
    $query = $pdo->prepare($querystring);
    $query->bindParam(':id_user', $id_user, \PDO::PARAM_INT);
    var_dump($query->execute());
  }

  /**
   * getAllRightsDb
   *
   * @return array
   */
  protected function getAllRightsDb()
  {
    $pdo = $this->getBdd();
    $querystring =
      "SELECT id_rights, name_right
      FROM rights";
    $query = $pdo->query($querystring);
    $result = $query->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * updateUserRightsDb
   *
   * @param  int $id_user
   * @param  int $id_rights
   * @return void
   */
  protected function updateUserRightsDb(int $id_user, int $id_rights)
  {
    $pdo = $this->getBdd();
    $querystring =
      "UPDATE users
      SET id_rights = :id_rights
      WHERE id_user = :id_user";
    $query = $pdo->prepare($querystring);
    $query->bindParam(':id_user', $id_user, \PDO::PARAM_INT);
    $query->bindParam(':id_rights', $id_rights, \PDO::PARAM_INT);
    $query->execute();
  }

  /**
   * countProducts
   *
   * @return void
   */
  protected function countProducts()
  {
    $pdo = $this->getBdd();
    $querystring =
      "SELECT COUNT(*) AS total FROM product";
    $query = $pdo->query($querystring);
    $result = $query->fetch(\PDO::FETCH_ASSOC);
    return $result['total'];
  }

  /**
   * getAllProductsByIdDb
   *
   * @param  int $offset
   * @param  int $prod_by_page
   * @return void
   */
  protected function getAllProductsByIdDb($offset, $prod_by_page)
  {
    $pdo = $this->getBdd();
    $querystring =
      "SELECT product.id_product, product.name, product.price, category.category_name, subcategory.subcategory_name, stocks.stocks
      FROM product
      NATURAL JOIN category
      NATURAL JOIN subcategory
      NATURAL JOIN stocks
      ORDER BY product.id_product
      LIMIT $offset, $prod_by_page";
    $query = $pdo->query($querystring);
    $result = $query->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * getProductStockByIdDB
   *
   * @param  int $id_product
   * @return int stocks in Database
   */
  private function getProductStockByIdDB(int $id_product)
  {
    $pdo = $this->getBdd();
    $querystring =
      "SELECT product.id_product, stocks.stocks
      FROM product
      NATURAL JOIN stocks
      WHERE product.id_product = $id_product";
    $query = $pdo->query($querystring);
    $fetch = $query->fetch(\PDO::FETCH_ASSOC);
    $result = (int)$fetch['stocks'];
    return $result;
  }

  /**
   * addStocksDb
   *
   * @param  înt $id_product
   * @param  înt $stocks
   * @return void
   */
  protected function addStocksDb(int $id_product, int $stocks)
  {
    $old_stocks = $this->getProductStockByIdDB($id_product);
    $new_stocks = $old_stocks + $stocks;
    $pdo = $this->getBdd();
    $querystring =
      "UPDATE stocks
      SET stocks.stocks = $new_stocks
      WHERE stocks.id_product = :id_product";
    $query = $pdo->prepare($querystring);
    $query->bindParam(':id_product', $id_product, \PDO::PARAM_INT);
    $query->execute();
  }

  /**
   * getAllCategoriesDB
   *
   * @return array
   */
  protected function getAllCategoriesDB()
  {
    $pdo = $this->getBdd();
    $querystring =
      "SELECT category.id_category, category.category_name, category.img_category
      FROM category";
    $query = $pdo->query($querystring);
    $result = $query->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * getAllSubcategoriesDB
   *
   * @return array
   */
  protected function getAllSubcategoriesDB()
  {
    $pdo = $this->getBdd();
    $querystring =
      "SELECT subcategory.id_subcategory, subcategory.subcategory_name, category.category_name
      FROM subcategory
      NATURAL JOIN category";
    $query = $pdo->query($querystring);
    $result = $query->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
  }

  protected function insertProductDb($product_name, $product_description, $product_price, $product_subcategory_id, $product_stocks, $product_image)
  {
    $pdo = $this->getBdd();
    $querystring =
      "SELECT subcategory.id_category AS product_category_id
      FROM subcategory
      WHERE subcategory.id_subcategory = :product_subcategory_id";
    $query = $pdo->prepare($querystring);
    $query->bindParam(':product_subcategory_id', $product_subcategory_id, \PDO::PARAM_INT);
    $query->execute();
    $product_category_id = $query->fetch(\PDO::FETCH_ASSOC);
    $product_category_id = $product_category_id['product_category_id'];
    $querystring =
      "INSERT INTO product (name, description, price, id_category, id_subcategory, date_product, img_product)
      VALUES (:product_name, :product_description, :product_price, :product_category_id, :product_subcategory_id, NOW(), :product_image);
      SELECT @mysql_id_product := LAST_INSERT_ID();
      INSERT INTO stocks (id_product, stocks)
      VALUES (@mysql_id_product, :product_stocks)";
    $query = $pdo->prepare($querystring);
    $query->bindParam(':product_name', $product_name, \PDO::PARAM_STR);
    $query->bindParam(':product_description', $product_description, \PDO::PARAM_STR);
    $query->bindParam(':product_price', $product_price, \PDO::PARAM_STR);
    $query->bindParam(':product_subcategory_id', $product_subcategory_id, \PDO::PARAM_INT);
    $query->bindParam(':product_category_id', $product_category_id, \PDO::PARAM_INT);
    $query->bindParam(':product_stocks', $product_stocks, \PDO::PARAM_INT);
    $query->bindParam(':product_image', $product_image, \PDO::PARAM_STR);
    $query->execute();
  }

  /**
   * getProductByIdDb
   *
   * @param  int $id_product
   * @return void
   */
  protected function getProductByIdDb($id_product)
  {
    $pdo = $this->getBdd();
    $querystring =
      "SELECT id_product, name, description, price, id_category, id_subcategory, date_product, img_product
      FROM product 
      WHERE id_product = :id_product";
    $query = $pdo->prepare($querystring);
    $query->bindParam(':id_product', $id_product, \PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(\PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * updateProductDb
   *
   * @param  int $id_product
   * @param  string $product_name
   * @param  string $product_description
   * @param  string $product_price
   * @param  int $product_subcategory_id
   * @param  string $product_image_name
   * @return void
   */
  public function updateProductDb($id_product, $product_name, $product_description, $product_price, $product_subcategory_id, $product_image_name)
  {
    $pdo = $this->getBdd();
    $querystring =
      "SELECT subcategory.id_category AS product_category_id
      FROM subcategory
      WHERE subcategory.id_subcategory = :product_subcategory_id";
    $query = $pdo->prepare($querystring);
    $query->bindParam(':product_subcategory_id', $product_subcategory_id, \PDO::PARAM_INT);
    $query->execute();
    $product_category_id = $query->fetch(\PDO::FETCH_ASSOC);
    $product_category_id = $product_category_id['product_category_id'];
    $querystring =
      "UPDATE product 
      SET name = :product_name, description = :product_description,price = :product_price, id_category = :product_category_id, id_subcategory = :product_subcategory_id, img_product = :product_image_name 
      WHERE id_product = :id_product";
    $query = $pdo->prepare($querystring);
    $query->bindParam(':id_product', $id_product, \PDO::PARAM_INT);
    $query->bindParam(':product_name', $product_name, \PDO::PARAM_STR);
    $query->bindParam(':product_description', $product_description, \PDO::PARAM_STR);
    $query->bindParam(':product_price', $product_price, \PDO::PARAM_STR);
    $query->bindParam(':product_category_id', $product_category_id, \PDO::PARAM_INT);
    $query->bindParam(':product_subcategory_id', $product_subcategory_id, \PDO::PARAM_INT);
    $query->bindParam(':product_image_name', $product_image_name, \PDO::PARAM_STR);
    $query->execute();
  }

  /**
   * deleteProdcutDb
   *
   * @param  int $id_product
   * @return void
   */
  protected function deleteProductDb($id_product)
  {
    $pdo = $this->getBdd();
    $querystring =
      "DELETE FROM product
      WHERE id_product = :id_product";
    $query = $pdo->prepare($querystring);
    $query->bindParam(':id_product', $id_product, \PDO::PARAM_INT);
    $query->execute();
  }
}
