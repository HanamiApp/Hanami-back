<?php

  namespace App\Data\DTO;

  use App\Data\Entities\User;
  require_once __DIR__ . '/../Entities/User.php';

  class UserDTO
  {

    public $id;
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $pathPhoto;

    public function __construct( $UserEntity )
    {
      if ( !is_array($UserEntity) ) $UserEntity = $UserEntity->toArray();
      $this->id = $UserEntity['id'];
      $this->firstName = $UserEntity['firstName'];
      $this->lastName = $UserEntity['lastName'];
      $this->email = $UserEntity['email'];
      $this->password = $UserEntity['password'];
      $this->pathPhoto = $UserEntity['pathPhoto'];
    }

    public function toEntity()
    {
      $Entity = new User();
      $Entity->id = $this->id;
      $Entity->firstName = $this->firstName;
      $Entity->lastName = $this->lastName;
      $Entity->email = $this->email;
      $Entity->password = $this->password;
      $Entity->pathPhoto = $this->pathPhoto;
      return $Entity;
    }

    public function toFilledEntity( $UserEntity )
    {
      $Entity = new User();
      $Entity->id = $UserEntity->id;
      $Entity->firstName = $this->firstName ?? $UserEntity->firstName;
      $Entity->lastName = $this->lastName ?? $UserEntity->lastName;
      $Entity->email = $this->email ?? $UserEntity->email;
      $Entity->password = $this->password ?? $UserEntity->password;
      $Entity->pathPhoto = $this->pathPhoto ?? $UserEntity->pathPhoto;
      return $Entity;
    }

  }

?>