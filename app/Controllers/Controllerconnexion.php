<?php

namespace app\controllers;

class Controllerconnexion extends \app\models\Modelconnexion
{
  // Properties


  // Methods

  public function connectUser($email, $password) {
    $email = htmlspecialchars(trim($email));
    $password = htmlspecialchars(trim($password));
    // Recherche d'un utilisateur en base de données
  }
}
