<?php

namespace app\classes;

/**
 * User
 */
class User
{

  // Properties

  /**
   * id_user
   *
   * @var int
   */
  private int $id_user;

  /**
   * email
   *
   * @var string
   */
  private string $email;

  /**
   * password
   *
   * @var string
   */
  private string $password;

  /**
   * id_rights
   *
   * @var int
   */
  private int $id_rights;

  /**
   * firstname
   *
   * @var string
   */
  private $firstname;

  /**
   * lastname
   *
   * @var string
   */
  private $lastname;

  /**
   * phone
   *
   * @var string
   */
  private $phone;

  /**
   * avatar
   *
   * @var string
   */
  private $avatar;

  /**
   * birthdate
   *
   * @var string
   */
  private $birthdate;

  /**
   * gender
   *
   * @var string
   */
  private $gender;

  //Setters

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
   * Set email
   *
   * @param  string  $email  email
   *
   * @return  self
   */
  public function setEmail(string $email)
  {
    $this->email = $email;

    return $this;
  }

  /**
   * Set password
   *
   * @param  string  $password  password
   *
   * @return  self
   */
  public function setPassword(string $password)
  {
    $this->password = $password;

    return $this;
  }

  /**
   * Set id_rights
   *
   * @param  int  $id_rights  id_rights
   *
   * @return  self
   */
  public function setId_rights(int $id_rights)
  {
    $this->id_rights = $id_rights;

    return $this;
  }

  /**
   * Set firstname
   *
   * @param  string  $firstname  firstname
   *
   * @return  self
   */
  public function setFirstname($firstname)
  {
    $this->firstname = $firstname;

    return $this;
  }

  /**
   * Set lastname
   *
   * @param  string  $lastname  lastname
   *
   * @return  self
   */
  public function setLastname($lastname)
  {
    $this->lastname = $lastname;

    return $this;
  }

  /**
   * Set phone
   *
   * @param  string  $phone  phone
   *
   * @return  self
   */
  public function setPhone($phone)
  {
    $this->phone = $phone;

    return $this;
  }

  /**
   * Set avatar
   *
   * @param  string  $avatar  avatar
   *
   * @return  self
   */
  public function setAvatar($avatar)
  {
    $this->avatar = $avatar;

    return $this;
  }

  /**
   * Set birthdate
   *
   * @param  string  $birthdate  birthdate
   *
   * @return  self
   */
  public function setBirthdate($birthdate)
  {
    $this->birthdate = $birthdate;

    return $this;
  }

  /**
   * Set gender
   *
   * @param  string  $gender  gender
   *
   * @return  self
   */
  public function setGender($gender)
  {
    $this->gender = $gender;

    return $this;
  }

  // Getters

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
   * Get email
   *
   * @return  string
   */
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * Get password
   *
   * @return  string
   */
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * Get id_rights
   *
   * @return  int
   */
  public function getId_rights()
  {
    return $this->id_rights;
  }

  /**
   * Get firstname
   *
   * @return  string
   */
  public function getFirstname()
  {
    return $this->firstname;
  }

  /**
   * Get lastname
   *
   * @return  string
   */
  public function getLastname()
  {
    return $this->lastname;
  }

  /**
   * Get phone
   *
   * @return  string
   */
  public function getPhone()
  {
    return $this->phone;
  }

  /**
   * Get avatar
   *
   * @return  string
   */
  public function getAvatar()
  {
    return $this->avatar;
  }

  /**
   * Get birthdate
   *
   * @return  string
   */
  public function getBirthdate()
  {
    return $this->birthdate;
  }

  /**
   * Get gender
   *
   * @return  string
   */
  public function getGender()
  {
    return $this->gender;
  }

  // Methods

  function __construct($id_user, $email, $password, $id_rights, $firstname, $lastname, $phone, $avatar, $birthdate, $gender)
  {
    $this->setId_user($id_user);
    $this->setEmail($email);
    $this->setPassword($password);
    $this->setId_rights($id_rights);
    $this->setFirstname($firstname);
    $this->setLastname($lastname);
    $this->setPhone($phone);
    $this->setAvatar($avatar);
    $this->setBirthdate($birthdate);
    $this->setGender($gender);
    return $this;
  }
}
