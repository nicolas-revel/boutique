<?php

namespace app\models;


/**
 * Modelinscription
 */
class Modelinscription extends Model
{

  // Properties



  // Methods

  private function getUserByMailDb($email)
  {
    $pdo = $this->getBdd();
    $querystring = "SELECT id_user, email FROM users WHERE email = :email";
    $query = $pdo->prepare($querystring);
    $query->bindParam(":email", $email, \PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(\PDO::FETCH_ASSOC);
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
    if (!empty($this->getUserByMailDb($email))) {
      throw new \Exception("Un compte existe déjà avec cet email, merci de vous connecter ou de choisir un autre mail");
    }
    try {
      $pdo = $this->getBdd();
      $querystring = "INSERT INTO users (email, password, id_rights) VALUES (:email, :password, :rights)";
      $query = $pdo->prepare($querystring);
      $query->bindParam(':email', $email, \PDO::PARAM_STR);
      $query->bindParam(':password', $password, \PDO::PARAM_STR);
      $query->bindParam(':rights', $rights, \PDO::PARAM_INT);
      $result = $query->execute();
      if ($result === false) {
        throw new \Exception("Il y a eu un problème lors de votre inscription, merci de réésayer plus tard.");
        try {
          return true;
        } catch (\Exception $e) {
          return $e;
        }
      }
    } catch (\Exception $e) {
      return $e;
    }
  }
}
