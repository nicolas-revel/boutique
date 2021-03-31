<?php

namespace app\models;

class Modelprofil extends model
{
  // Properties


  // Methods

  /**
   * getUserByMail
   *
   * @param  string $email
   * @return array || null
   */
  protected function getUserByMail($email)
  {
    $pdo = $this->getBdd();
    $querystring = "SELECT id_user, email, password, id_rights, firstname, lastname, phone, avatar, DATE_FORMAT(birthdate, '%d/%m/%Y') AS birthdate, gender FROM users WHERE email = :email";
    $query = $pdo->prepare($querystring);
    $query->bindParam(':email', $email, \PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(\PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * getUserByMail
   *
   * @param  string $email
   * @return void
   */
  protected function getUserById($id_user)
  {
    $pdo = $this->getBdd();
    $querystring = "SELECT id_user, email, password, id_rights, firstname, lastname, phone, avatar, DATE_FORMAT(birthdate, '%d-%m-%Y') AS birthdate, gender FROM users WHERE id_user = :id_user";
    $query = $pdo->prepare($querystring);
    $query->bindParam(':id_user', $id_user, \PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(\PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * getAdressById_userDb
   *
   * @param  int $id_user
   * @return array
   */
  protected function getAdressById_userDb($id_user)
  {
    $pdo = $this->getBdd();
    $querystring = "SELECT id_adress, title, id_user, country, town, postal_code, street, infos, number FROM adresses WHERE id_user = $id_user";
    $query = $pdo->prepare($querystring);
    $query->execute();
    $result = $query->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
  }

  protected function getAdressById_adressDB($id_adress)
  {
    $pdo = $this->getBdd();
    $querystring = "SELECT id_adress, title, id_user, country, town, postal_code, street, infos, number FROM adresses WHERE id_adress = $id_adress";
    $query = $pdo->prepare($querystring);
    $query->execute();
    $result = $query->fetch(\PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * updateUserDB
   *
   * @param  int $id_user
   * @param  string $email
   * @param  string $password
   * @param  string $firstname
   * @param  string $lastname
   * @param  string $avatar
   * @param  string $birthdate
   * @param  string $gender
   * @return void
   */
  protected function updateUserDB(int $id_user, $email, $password, $firstname, $lastname, $phone, $avatar, $birthdate, $gender)
  {
    $pdo = $this->getBdd();
    $querystring = "UPDATE users SET email = :email, password = :password, firstname = :firstname, lastname = :lastname, phone = :phone, avatar = :avatar, birthdate = :birthdate, gender = :gender WHERE id_user = $id_user";
    $query = $pdo->prepare($querystring);
    $query->bindParam(':email', $email, \PDO::PARAM_STR);
    $query->bindParam(':password', $password, \PDO::PARAM_STR);
    $query->bindParam(':firstname', $firstname, \PDO::PARAM_STR);
    $query->bindParam(':lastname', $lastname, \PDO::PARAM_STR);
    $query->bindParam(':phone', $phone, \PDO::PARAM_STR);
    $query->bindParam(':avatar', $avatar, \PDO::PARAM_STR);
    $query->bindParam(':birthdate', $birthdate, \PDO::PARAM_STR);
    $query->bindParam(':gender', $gender, \PDO::PARAM_STR);
    $query->execute();
  }

  /**
   * insertAdressDb
   *
   * @param  int $id_user
   * @param  int $id_guest
   * @param  string $title
   * @param  string $country
   * @param  string $town
   * @param  string $street
   * @param string $postal_code
   * @param  string $infos
   * @param  int $number
   * @return void
   */
  protected function insertAdressDb(?int $id_user, ?int $id_guest, string $title, string $country, string $town, string $postal_code, string $street, ?string $infos, int $number)
  {
    $pdo = $this->getBdd();
    $querystring = "INSERT INTO adresses (title, id_user, id_guest, country, town, postal_code, street, infos, number) VALUES (:title, :id_user, :id_guest, :country, :town, :postal_code, :street, :infos, :number)";
    $query = $pdo->prepare($querystring);
    $query->bindParam(':id_user', $id_user, \PDO::PARAM_INT);
    $query->bindParam(':id_guest', $id_guest, \PDO::PARAM_INT);
    $query->bindParam(':title', $title, \PDO::PARAM_STR);
    $query->bindParam(':country', $country, \PDO::PARAM_STR);
    $query->bindParam(':town', $town, \PDO::PARAM_STR);
    $query->bindParam(':postal_code', $postal_code, \PDO::PARAM_STR);
    $query->bindParam(':street', $street, \PDO::PARAM_STR);
    $query->bindParam(':infos', $infos, \PDO::PARAM_STR);
    $query->bindParam(':number', $number, \PDO::PARAM_INT);
    $query->execute();
  }

  /**
   * updateAdressDb
   *
   * @param  int $id_adress
   * @param  string $title
   * @param  string $country
   * @param  string $town
   * @param  string $street
   * @param  string $infos
   * @param  int $number
   * @return void
   */
  protected function updateAdressDb($id_adress, $title, $country, $town, $postal_code, $street, $infos, $number)
  {
    $pdo = $this->getBdd();
    $querystring = "UPDATE adresses SET title = :title, country = :country, town = :town, postal_code = :postal_code, street = :street, infos = :infos, number = :number WHERE id_adress = $id_adress";
    $query = $pdo->prepare($querystring);
    $query->bindParam(':title', $title, \PDO::PARAM_STR);
    $query->bindParam(':country', $country, \PDO::PARAM_STR);
    $query->bindParam(':town', $town, \PDO::PARAM_STR);
    $query->bindParam(':postal_code', $postal_code, \PDO::PARAM_STR);
    $query->bindParam(':street', $street, \PDO::PARAM_STR);
    $query->bindParam(':infos', $infos, \PDO::PARAM_STR);
    $query->bindParam(':number', $number, \PDO::PARAM_INT);
    $query->execute();
  }

  /**
   * deleteAdressDb
   *
   * @param  int $id_adress
   * @return void
   */
  protected function deleteAdressDb($id_adress)
  {
    $pdo = $this->getBdd();
    $querystring = "DELETE FROM adresses WHERE id_adress = :id_adress";
    $query = $pdo->prepare($querystring);
    $query->bindParam(":id_adress", $id_adress, \PDO::PARAM_INT);
    $query->execute();
  }

  protected function getOrderById_userDb($id_user)
  {
    $pdo = $this->getBdd();
    $querystring = "SELECT id_order, date_order, total_amount, status.name AS status FROM ordershipping INNER JOIN status ON ordershipping.id_status = status.id_status WHERE ordershipping.id_user = :id_user ORDER BY date_order LIMIT 5";
    $query = $pdo->prepare($querystring);
    $query->bindParam(':id_user', $id_user, \PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
  }
}
