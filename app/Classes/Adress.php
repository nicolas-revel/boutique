<?php

namespace app\classes;

class Adress
{
  // Properties

  /**
   * id_adress
   *
   * @var string
   */
  private string $id_adress;

  /**
   * id_user
   *
   * @var int
   */
  private int $id_user;

  /**
   * country
   *
   * @var string
   */
  private string $country;

  /**
   * town
   *
   * @var string
   */
  private string $town;

  /**
   * street
   *
   * @var string
   */
  private string $street;

  /**
   * infos
   *
   * @var string
   */
  private string $infos;

  /**
   * number
   *
   * @var int
   */
  private int $number;

  // Setters

  /**
   * Set id_adress
   *
   * @param  string  $id_adress  id_adress
   *
   * @return  self
   */
  public function setId_adress(string $id_adress)
  {
    $this->id_adress = $id_adress;

    return $this;
  }

  /**
   * Set id_user
   *
   * @param  int  $id_user  id_user
   *
   * @return  self
   */
  public function setId_user(int $id_user)
  {
    $this->id_user = $id_user;

    return $this;
  }

  /**
   * Set country
   *
   * @param  string  $country  country
   *
   * @return  self
   */
  public function setCountry(string $country)
  {
    $this->country = $country;

    return $this;
  }

  /**
   * Set town
   *
   * @param  string  $town  town
   *
   * @return  self
   */
  public function setTown(string $town)
  {
    $this->town = $town;

    return $this;
  }

  /**
   * Set street
   *
   * @param  string  $street  street
   *
   * @return  self
   */
  public function setStreet(string $street)
  {
    $this->street = $street;

    return $this;
  }

  /**
   * Set infos
   *
   * @param  string  $infos  infos
   *
   * @return  self
   */
  public function setInfos(string $infos)
  {
    $this->infos = $infos;

    return $this;
  }

  /**
   * Set number
   *
   * @param  int  $number  number
   *
   * @return  self
   */
  public function setNumber(int $number)
  {
    $this->number = $number;

    return $this;
  }

  // Getters

  /**
   * Get id_adress
   *
   * @return  string
   */
  public function getId_adress()
  {
    return $this->id_adress;
  }

  /**
   * Get id_user
   *
   * @return  int
   */
  public function getId_user()
  {
    return $this->id_user;
  }

  /**
   * Get country
   *
   * @return  string
   */
  public function getCountry()
  {
    return $this->country;
  }

  /**
   * Get town
   *
   * @return  string
   */
  public function getTown()
  {
    return $this->town;
  }

  /**
   * Get street
   *
   * @return  string
   */
  public function getStreet()
  {
    return $this->street;
  }

  /**
   * Get infos
   *
   * @return  string
   */
  public function getInfos()
  {
    return $this->infos;
  }

  /**
   * Get number
   *
   * @return  int
   */
  public function getNumber()
  {
    return $this->number;
  }

  // Methods

  function __construct($id_adress, $id_user, $country, $town, $street, $infos, $number)
  {
    $this->setId_adress($id_adress);
    $this->setId_user($id_user);
    $this->setCountry($country);
    $this->setTown($town);
    $this->setStreet($street);
    $this->setInfos($infos);
    $this->setNumber($number);
    return $this;
  }
}
