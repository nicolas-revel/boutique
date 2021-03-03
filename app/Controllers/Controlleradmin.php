<?php

namespace app\controllers;

class Controlleradmin extends \app\models\Modeladmin
{
  // Properties



  //Methods

  public function getAllRights()
  {
    return $this->getAllRightsDb();
  }

  /**
   * getAllUsersById
   *
   * @param  array $result
   * @return array
   */
  public function getAllUsersById()
  {
    return $this->getAllUserByIdDb();
  }

  /**
   * deleteUser
   *
   * @param  int $id_user
   * @return void
   */
  public function deleteUser(int $id_user)
  {
    var_dump($this->deleteUserDb($id_user));
  }

  /**
   * updateUserRights
   *
   * @param  int $id_user
   * @param  int $id_rights
   * @return void
   */
  public function updateUserRights($id_user, $id_rights)
  {
    $id_user = htmlspecialchars(trim(intval($id_user)));
    $id_rights = htmlspecialchars(trim(intval($id_rights)));
    $this->updateUserRightsDb($id_user, $id_rights);
  }

  public function getAllProductsById()
  {
    return $this->getAllProductsByIdDb();
  }
}
