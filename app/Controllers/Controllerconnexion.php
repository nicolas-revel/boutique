<?php

namespace app\controllers;

use app\classes\User;

class Controllerconnexion extends \app\models\Modelconnexion
{
  // Properties


  // Methods

  public function connectUser($email, $password)
  {
    $email = htmlspecialchars(trim($email));
    $password = htmlspecialchars(trim($password));
    $userDB = $this->getUserByEmail($email);
    if (!password_verify($password, $userDB['password'])) {
      throw new \Exception("Votre mot de passe est incorrect.");
    }
    try {
      $user = new User($userDB['id_user'], $userDB['email'], $userDB['password'], $userDB['id_rights'], $userDB['firstname'], $userDB['lastname'], $userDB['phone'], $userDB['avatar'], $userDB['birthdate'], $userDB['gender']);
      return $user;
    } catch (\Exception $e) {
      return $e;
    }
  }
}
