<?php

namespace app\controllers;

use app\models\Modeldetailorder;

class Controllerdetailorder extends Modeldetailorder
{

  // Properties



  // Methods

  public function getOrderDetail(?int $id_order)
  {
    return $this->getOrderDetailDb($id_order);
  }
}
