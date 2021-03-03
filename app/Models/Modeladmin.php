<?php

namespace app\models;

class Modeladmin extends model
{

  public function addProductBdd($name, $description, $price, $id_subcategory, $img_product): void
  {
    $bdd = $this->getBdd();

    $req = $bdd->prepare("INSERT INTO product (name, description, price, id_subcategory, date_product, img_product) VALUES (:name, :description, :price, :id_subcategory, NOW(), :img_product)");
    $req->bindValue(':name', $name);
    $req->bindValue(':description', $description);
    $req->bindValue(':price', $price);
    $req->bindValue(':id_subcategory', $id_subcategory);
    $req->bindValue(':img_product', $img_product);
    $req->execute() or die(print_r($req->errorInfo()));
  }

  public function addCategoryBdd($category_name, $img_category): void
  {
    $bdd = $this->getBdd();

    $req = $bdd->prepare("INSERT INTO category (category_name, img_category) VALUES (:category_name, :img_category)");
    $req->bindValue(':category_name', $category_name);
    $req->bindValue(':img_category', $img_category);
    $req->execute() or die(print_r($req->errorInfo()));
  }

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

  protected function getAllProductsByIdDb()
  {
    $pdo = $this->getBdd();
    $querystring =
      "SELECT product.id_product, product.name, product.price, category.category_name, subcategory.subcategory_name, stocks.stocks
      FROM product
      NATURAL JOIN category
      NATURAL JOIN subcategory
      NATURAL JOIN stocks
      ORDER BY product.id_product ";
    $query = $pdo->query($querystring);
    $result = $query->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
  }
}
