<?php

namespace app\models;

class Modelprofil extends model
{
  // Properties

  /**
   * getUserByMail
   *
   * @param  string $email
   * @return array || null
   */
  protected function getUserByMail($email)
  {
    $pdo = $this->dbconnect;
    $querystring = "SELECT * FROM users WHERE email = :email";
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
    $pdo = $this->dbconnect;
    $querystring = "SELECT * FROM users WHERE id_user = :id_user";
    $query = $pdo->prepare($querystring);
    $query->bindParam(':id_user', $id_user, \PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(\PDO::FETCH_ASSOC);
    return $result;
  }

  // Methods

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
  protected function updateUserDB($id_user, $email, $password, $firstname, $lastname, $avatar, $birthdate, $gender)
  {
    try {
      $pdo = $this->dbconnect;
      $querystring = "UPDATE users SET email = :email, password = :password, firstname = :firstname, lastname = :lastname, avatar = :avatar, birthdate = :birthdate, gender = :gender WHERE id_user = $id_user";
      $query = $pdo->prepare($querystring);
      $query->bindParam(':email', $email, \PDO::PARAM_STR);
      $query->bindParam(':password', $password, \PDO::PARAM_STR);
      $query->bindParam(':firstname', $firstname, \PDO::PARAM_STR);
      $query->bindParam(':lastname', $lastname, \PDO::PARAM_STR);
      $query->bindParam(':avatar', $avatar, \PDO::PARAM_STR);
      $query->bindParam(':birthdate', $birthdate, \PDO::PARAM_STR);
      $query->bindParam(':gender', $gender, \PDO::PARAM_STR);
      $query->execute();
    } catch (\PDOException $e) {
      return $e;
    }
  }
}
