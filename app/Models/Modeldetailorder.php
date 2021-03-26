<?php

namespace app\models;

use app\models\model;

class Modeldetailorder extends model
{
  // Properties



  // Methods

  protected function getOrderDetailDb($id_order)
  {
    $pdo = $this->getBdd();
    $querystring =
      "SELECT ordershipping.id_order, ordershipping.date_order, ordershipping.total_amount, ordershipping.id_user, status.name AS status, order_meta.quantity, order_meta.amount, product.id_product, product.name, product.price, product.img_product, product.product_availability, subcategory.subcategory_name AS subcategory, category.category_name AS category
      FROM ordershipping
      INNER JOIN status ON ordershipping.id_status = status.id_status
      INNER JOIN order_meta ON order_meta.id_order = ordershipping.id_order
      INNER JOIN product ON order_meta.id_product = product.id_product
      INNER JOIN category ON category.id_category = product.id_category
      INNER JOIN subcategory ON subcategory.id_subcategory = product.id_subcategory
      WHERE ordershipping.id_order = :id_order  
      ORDER BY category.category_name ASC, subcategory.subcategory_name ASC, product.name ASC";
    $query = $pdo->prepare($querystring);
    $query->bindParam(':id_order', $id_order, \PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
  }
}
