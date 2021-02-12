<?php

namespace app\models;


/**
 * Modelinscription
 */
class Modelinscription extends Model
{

  // Properties



  // Methods
  
  /**
   * getUserByMail
   *
   * @param  string $email
   * @return array | null
   */
  private function getUserByMail(string $email)
  {
    $pdo = $this->dbconnect;
    $querystring = "SELECT * FROM users WHERE email = :email";
    $query = $pdo->prepare($querystring);
    $query->bindParam(':email', $email, \PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetchAll(\PDO::FETCH_ASSOC);
    var_dump($result);
    return $result;
  }

  /**
   * insertUserDB
   *
   * @param  string $email
   * @param  string $password
   * @param  int $rights
   * @param  string $firstname
   * @param  string $lastname
   * @param  string $avatar
   * @param  string $birthdate
   * @param  string $gender
   * @return bool
   */
  public function insertUserDB(string $email, string $password, int $rights = 1)
  {
    if (!empty($this->getUserByMail($email))) {
      throw new \Exception("Un compte existe déjà avec cet email, merci de vous connecter ou de choisir un autre mail", 1);
    }
    try {
      $pdo = $this->dbconnect;
      $querystring = "INSERT INTO users (email, password, id_rights) VALUES (:email, :password, :rights)";
      $query = $pdo->prepare($querystring);
      $query->bindParam(':email', $email, \PDO::PARAM_STR);
      $query->bindParam(':password', $password, \PDO::PARAM_STR);
      $query->bindParam(':rights', $rights, \PDO::PARAM_INT);
      $result = $query->execute();
      if ($result === false) {
        throw new \Exception("Il y a eu un problème lors de votre inscription, merci de réésayer plus tard.");
        try {
          return $result;
        } catch (\Exception $e) {
          return $e;
        }
      }
    } catch (\Exception $e) {
      return $e;
    }
  }
}
