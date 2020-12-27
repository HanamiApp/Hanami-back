<?php

  namespace App\Data\Entities;

  use App\Data\Entities\Interfaces\IEntity;
  require_once __DIR__ . '/interfaces/IEntity.php';

  class PlantState implements IEntity
  {

    private $id;
    private $state;
    private $condition;
    private $day;
    
    // constructor
    public function __construct( $state = 'IN_PROCESS', $condition = 'HEALTHY', $day = null )
    {
      $this->id = null;
      $this->state = $state;
      $this->condition = $condition;
      $this->day = ($day === null) ? date("Y/m/d") : $day;
    }
    
    // magic function __get and __set
    public function __get( $variable )
    {
      return $this->$variable;
    }
    public function __set( $variable, $value )
    {
      $this->$variable = $value;
    }

    // ToString
    public function toArray()
    {
      return [
        'id' => $this->id, 
        'state' => $this->state, 
        'condition' => $this->condition, 
        'day' => $this->day, 
        'id_plant' => $this->plantId
      ];
    }
    
  }