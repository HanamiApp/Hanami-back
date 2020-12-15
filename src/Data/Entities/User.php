<?php


  namespace App\Data\Entities;
  use App\Data\Enums\RegionEnum as RegionEnum;
  use App\Services\Logger as Logger;
  require_once __DIR__ . '/../../Services/Logger.php';
  require_once __DIR__ . '/../Enums/RegionEnum.php';

  class User
  {

    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $region;

    // constructor
    public function __construct( $firstName = null, $lastName = null, $email = null, $password = null, $region = null )
    {
      $this->id = null;
      $this->firstName = $firstName;
      $this->lastName = $lastName;
      $this->email = $email;
      $this->password = $password;
      $this->region = $region;
    }

    // __get and __set
    public function __get( $variable )
    {
      return $this->$variable;
    }
    public function __set( $variable, $value )
    {
      $this->$variable = $value;
    }

    //toString
    public function __toArray()
    {
      return [
        'id' => $this->id,
        'firstName' => $this->firstName,
        'lastName' => $this->lastName,
        'email' => $this->email,
        'password' => $this->password,
        'region' => $this->region
      ];
    }

  }


?>