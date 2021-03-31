<?php

namespace app\models;

class Modelconnexion extends model
{
  // Properties



  // Methods

  public function getUserByEmail($email)
  {
    $pdo = $this->getBdd();
    $querystring = "SELECT id_user, email, password, id_rights, firstname, lastname, phone, avatar, DATE_FORMAT(birthdate, '%d/%m/%Y') AS birthdate, gender FROM users WHERE email = :email";
    $query = $pdo->prepare($querystring);
    $query->bindParam(':email', $email, \PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(\PDO::FETCH_ASSOC);
    if (empty($result)) {
      throw new \Exception("Il n'y a pas d'utilisateur avec cette adresse mail dans la base de donnée.");
    }
    try {
      return $result;
    } catch (\Exception $e) {
      return $e;
    }
  }
}
