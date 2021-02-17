<?php

namespace app\controllers;

class controllerprofil extends \app\models\Modelprofil
{
  // Properties



  // Methods

  public function updateUser($actual_user, $checkpassword, $email, $password, $c_password, $firstname, $lastname, $avatar, $birthdate, $gender)
  {
    if (!password_verify($checkpassword, $actual_user->getPassword())) {
      throw new \Exception("Merci d'indiquer votre mot de passe actuel afin de valider les modifications");
    }
    if ($avatar['error'] !== 0) {
      throw new \Exception("Il y a eu une erreur lors de l'upload de votre avatar, merci de bien vouloir recommencer");
    }
    if ($avatar['size'] > 1000000) {
      throw new \Exception("Merci de choisir un fichier inférieur à 1 Go.");
    }
    if ($avatar['type'] !== 'image/png' && $avatar['type'] !== 'image/jpg' && $avatar['type'] !== 'image/jpeg') {
      throw new \Exception("Merci de choisir une image au format demandé.");
    }
    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
      throw new \Exception("Merci de rentrer une adresse email valide");
    }
    if (!empty($email) && !empty($this->getUserByMail($email))) {
      throw new \Exception("Cette adresse mail existe déjà, merci d'en choisir une autre");
    }
    if (!empty($password) && $c_password !== $password) {
      throw new \Exception("Merci de bien confirmer votre mot de passe");
    }
    if (!empty($password) && preg_match('#^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$#', $password) === 0 || preg_match('#^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$#', $password) === false) {
      throw new \Exception("Merci de fournir un mot de passe au format demandé");
    }
    if (!empty($birthdate) && preg_match('#^(19[0-9]{2}|2[0-9]{3})-(0[1-9]|1[012])-([123]0|[012][1-9]|31)$#', $birthdate) === 0 || preg_match('#^(19[0-9]{2}|2[0-9]{3})-(0[1-9]|1[012])-([123]0|[012][1-9]|31)$#', $birthdate) === false) {
      throw new \Exception("Merci de fournir une date au format demandé");
    }
    if (empty($email)) {
      $email = $actual_user->getEmail();
    } else {
      $email = htmlspecialchars(trim($email));
    }
    if (empty($password)) {
      $password = $actual_user->getPassword();
    } else {
      $password = htmlspecialchars(trim(password_hash($password, PASSWORD_DEFAULT)));
    }
    if (empty($firstname)) {
      $firstname = $actual_user->getFirstname();
    } else {
      $firstname = htmlspecialchars(trim($firstname));
    }
    if (empty($lastname)) {
      $lastname = $actual_user->getLastname();
    } else {
      $lastname = htmlspecialchars(trim($lastname));
    }
    if (empty($avatar)) {
      $avatar_name = $actual_user->getAvatar();
    } else {
      $avatar_infos = pathinfo($avatar['name']);
      $extension_avatar = $avatar_infos['extension'];
      $avatar_name = md5(uniqid()) . '.' . $extension_avatar;
      move_uploaded_file($avatar['tmp_name'], "../images/imageavatar/$avatar_name");
    }
    if (empty($birthdate)) {
      $birthdate = $actual_user->getBirthdate();
    } else {
      $birthdate = htmlspecialchars(trim($birthdate));
    }
    if (empty($gender)) {
      $gender = $actual_user->getGender();
    } else {
      $gender = htmlspecialchars(trim($gender));
    }
    $this->updateUserDB($actual_user->getId_user(), $email, $password, $firstname, $lastname, $avatar_name, $birthdate, $gender);
    try {
      $updateduser = $this->getUserById($actual_user->getId_user());
      $user = new \app\classes\User($updateduser['id_user'], $updateduser['email'], $updateduser['password'], $updateduser['id_rights'], $updateduser['firstname'], $updateduser['lastname'], $updateduser['avatar'], $updateduser['birthdate'], $updateduser['gender']);
      return $user;
    } catch (\Exception $e) {
      return $e;
    }
  }
}
