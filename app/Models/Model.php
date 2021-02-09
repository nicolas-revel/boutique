<?php

namespace app\models;

class model
{

  // Properties

  private $dbconnect;

  // Methods
  
  function __construct()
  {
    $pdo = new \PDO('mysql:dbname=boutique;host=localhost', 'root', '');
    $this->dbconnect = $pdo;
  }

}