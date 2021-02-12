<?php

namespace app\models;

class Model
{

  // Properties

  protected $dbconnect;

  // Methods

  function __construct()
  {
    $pdo = new \PDO('mysql:dbname=boutique;host=localhost', 'root', '');
    $this->dbconnect = $pdo;
  }
}
