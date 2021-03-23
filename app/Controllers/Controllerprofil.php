<?php

namespace app\controllers;

use app\classes\Adress;

class controllerprofil extends \app\models\Modelprofil
{
  // Properties



  // Methods

  /**
   * getAdressById_user
   *
   * @param  int $id_user
   * @return array
   */
  public function getAdressById_user($id_user)
  {
    $db_adresses = $this->getAdressById_userDb($id_user);
    foreach ($db_adresses as $adress) {
      $adresses[$adress['id_adress']] = new Adress($adress['id_adress'], $adress['title'], $adress['id_user'], $adress['country'], $adress['town'], $adress['postal_code'], $adress['street'], $adress['infos'], $adress['number']);
    }
    if (isset($adresses)) {
      return $adresses;
    } else {
      return false;
    }
  }

  /**
   * getAdressById_adress
   *
   * @param  int $id_adress
   * @return object
   */
  public function getAdressById_adress($id_adress)
  {
    $db_adress = $this->getAdressById_adressDB($id_adress);
    $adress = new \app\classes\Adress($db_adress['id_adress'], $db_adress['title'], $db_adress['id_user'], $db_adress['country'], $db_adress['town'], $db_adress['postal_code'], $db_adress['street'], $db_adress['infos'], $db_adress['number']);
    return $adress;
  }

  public function updateUser($actual_user, $checkpassword, $email, $password, $c_password, $firstname, $lastname, $phone, $avatar, $birthdate, $gender)
  {
    if (!password_verify($checkpassword, $actual_user->getPassword())) {
      throw new \Exception("Merci d'indiquer votre mot de passe actuel afin de valider les modifications");
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
    if (!empty($password) && preg_match('/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/', $password) === 0 || preg_match('/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/', $password) === false) {
      throw new \Exception("Merci de fournir un mot de passe au format demandé");
    }
    if (!empty($birthdate) && preg_match('/^(19[0-9]{2}|2[0-9]{3})-(0[1-9]|1[012])-([123]0|[012][1-9]|31)$/', $birthdate) === 0 || preg_match('/^(19[0-9]{2}|2[0-9]{3})-(0[1-9]|1[012])-([123]0|[012][1-9]|31)$/', $birthdate) === false) {
      throw new \Exception("Merci de fournir une date au format demandé");
    }
    if (!empty($phone) && preg_match("/^(?:(?:(?:\+|00)33\D?(?:\D?\(0\)\D?)?)|0){1}[1-9]{1}(?:\D?\d{2}){4}$/", $phone) === 0 && preg_match("/^(?:(?:(?:\+|00)33\D?(?:\D?\(0\)\D?)?)|0){1}[1-9]{1}(?:\D?\d{2}){4}$/", $phone) === false) {
      throw new \Exception("Merci de fournir un numéro de téléphone au format valide");
    }
    if (empty($email)) {
      $email = $actual_user->getEmail();
    } else {
      $email = htmlspecialchars(trim($email));
    }
    if (empty($phone)) {
      $phone = $actual_user->getPhone();
    } else {
      $phone = htmlspecialchars(trim($phone));
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
    if (empty($avatar['name'])) {
      $avatar_name = $actual_user->getAvatar();
    } else {
      $avatar_infos = pathinfo($avatar['name']);
      $extension_avatar = $avatar_infos['extension'];
      $avatar_name = md5(uniqid()) . '.' . $extension_avatar;
      move_uploaded_file($avatar['tmp_name'], "../images/imageavatar/$avatar_name");
    }
    if (empty($birthdate)) {
      $birthdate = str_replace('/', '-', $actual_user->getBirthdate());
      $birthdate = new \DateTime($birthdate);
      $birthdate = $birthdate->format('Y-m-d');
    } else {
      $birthdate = htmlspecialchars(trim($birthdate));
    }
    if (empty($gender)) {
      $gender = $actual_user->getGender();
    } else {
      $gender = htmlspecialchars(trim($gender));
    }
    $this->updateUserDB($actual_user->getId_user(), $email, $password, $firstname, $lastname, $phone, $avatar_name, $birthdate, $gender);
    try {
      $updateduser = $this->getUserById($actual_user->getId_user());
      $user = new \app\classes\User($updateduser['id_user'], $updateduser['email'], $updateduser['password'], $updateduser['id_rights'], $updateduser['firstname'], $updateduser['lastname'], $updateduser['phone'], $updateduser['avatar'], $updateduser['birthdate'], $updateduser['gender']);
      return $user;
    } catch (\Exception $e) {
      return $e;
    }
  }

  /**
   * insertAdress
   *
   * @param  int $id_user
   * @param int $id_guest
   * @param  string $title
   * @param  string $country
   * @param  string $town
   * @param  string $street
   * @param  string $infos
   * @param  int $number
   * @return void
   */
  public function insertAdress($id_user, $id_guest, $title, $country, $town, $postal_code, $street, $infos, $number)
  {
    if (empty($title) || empty($country) || empty($town) || empty($country) || empty($postal_code) || empty($street) || empty($number)) {
      throw new \Exception("Merci de remplir l'ensemble des champs nécessaires.");
    }
    if (empty($infos)) {
      $infos = null;
    } else {
      $infos = htmlspecialchars(trim($infos));
    }
    $title = htmlspecialchars(trim($title));
    $country = htmlspecialchars(trim($country));
    $town = htmlspecialchars(trim($town));
    $postal_code = htmlspecialchars(trim($postal_code));
    $street = htmlspecialchars(trim($street));
    $number = htmlspecialchars(trim($number));
    $this->insertAdressDb($id_user, $id_guest, $title, $country, $town, $postal_code, $street, $infos, $number);
  }

  /**
   * updateAdress
   *
   * @param  object $actual_adress
   * @param  int $id_adress
   * @param  string $title
   * @param  string $country
   * @param  string $town
   * @param  string $street
   * @param  string $infos
   * @param  int $number
   * @return void
   */
  public function updateAdress($actual_adress, $title, $country, $town, $postal_code, $street, $infos, $number)
  {
    if (empty($title)) {
      $title = $actual_adress->gettitTitle();
    } else {
      $title = htmlspecialchars(trim($title));
    }
    if (empty($country)) {
      $country = $actual_adress->getCount();
    } else {
      $country = htmlspecialchars(trim($country));
    }
    if (empty($town)) {
      $town = $actual_adress->getTown();
    } else {
      $town = htmlspecialchars(trim($town));
    }
    if (empty($postal_code)) {
      $postal_code = $actual_adress->getPostal_code();
    } else {
      $postal_code = htmlspecialchars(trim($postal_code));
    }
    if (empty($street)) {
      $street = $actual_adress->getStreet();
    } else {
      $street = htmlspecialchars(trim($street));
    }
    if (empty($infos)) {
      $infos = $actual_adress->getInfos();
    } else {
      $infos = htmlspecialchars(trim($infos));
    }
    if (empty($number)) {
      $number = $actual_adress->getNumber();
    } else {
      $number = htmlspecialchars(trim($number));
    }
    $this->updateAdressDb($actual_adress->getId_adress(), $title, $country, $town, $postal_code, $street, $infos, $number);
  }

  /**
   * deleteAdress
   *
   * @param  int $id_adress
   * @return void
   */
  public function deleteAdress($id_adress)
  {
    $this->deleteAdressDb($id_adress);
  }

  public function getOrderById_user($id_user)
  {
    $orders = $this->getOrderById_userDb($id_user);
    return $orders;
  }
}
