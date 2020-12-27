<?php


  namespace App\Data\Entities;
  use App\Data\Enums\RegionEnum as RegionEnum;
  use App\Services\Logger as Logger;
  use App\Data\Entities\Interfaces\IEntity;
  require_once __DIR__ . '/interfaces/IEntity.php';
  require_once __DIR__ . '/../../Services/Logger.php';
  require_once __DIR__ . '/../Enums/RegionEnum.php';

  class User implements IEntity
  {

    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $region;
    private $username;
    private $pathPhoto;

    // constructor
    public function __construct( $firstName = null, $lastName = null, $username = null, $email = null, $password = null, $region = null, $pathPhoto = null )
    {
      $this->id = null;
      $this->firstName = $firstName;
      $this->lastName = $lastName;
      $this->email = $email;
      $this->password = $password;
      $this->region = $region;
      $this->username = $username;
      $this->pathPhoto = $pathPhoto;
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

    // toString
    public function toArray()
    {
      return [
        'id' => $this->id,
        'firstName' => $this->firstName,
        'lastName' => $this->lastName,
        'username' => $this->username,
        'email' => $this->email,
        'password' => $this->password,
        'region' => $this->region,
        'pathPhoto' => $this->pathPhoto
      ];
    }

  }


?>