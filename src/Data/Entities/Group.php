<?php

  
  namespace App\Data\Entities;

  use App\Data\Entities\Interfaces\IEntity;
  use App\Data\Enums\GroupEnum as GroupEnum;
  require_once __DIR__ . '/interfaces/IEntity.php';
  require_once __DIR__ . '/../Enums/GroupEnum.php';

  class Group implements IEntity
  {

    private $id;
    private $name;

    // constructor
    public function __construct( $name = null )
    {
      $this->id = null;
      $this->name = $name;
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

    // toArray
    public function toArray()
    {
      return [
        'id'    => $this->id,
        'name'  => $this->name
      ];
    }


  }


?>