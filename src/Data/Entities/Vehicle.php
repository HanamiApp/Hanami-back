<?php

  namespace App\Data\Entities;

  use App\Data\Entities\Interfaces\IEntity;
  require_once __DIR__ . '/interfaces/IEntity.php';

  class Vehicle implements IEntity
  {

    private $id;
    private $name;
    private $co2_multiplier;

    public function __construct( $name = null, $co2_multiplier = null )
    {
      $this->id = null;
      $this->name = $name;
      $this->co2_multiplier = $co2_multiplier;
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
        'id'              => $this->id,
        'name'            => $this->name,
        'co2_multiplier'  => $this->co2_multiplier
      ];
    }

  }

?>