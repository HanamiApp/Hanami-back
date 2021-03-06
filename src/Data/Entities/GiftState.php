<?php

  
  namespace App\Data\Entities;

  use App\Data\Entities\Interfaces\IEntity;
  require_once __DIR__ . '/interfaces/IEntity.php';

  class GiftState implements IEntity
  {

    private $id;
    private $state;

    // constructor
    public function __construct( $state = 'IN_PROCESS' )
    {
      $this->id = null;
      $this->state = $state;
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
        'state' => $this->state
      ];
    }

  }


?>