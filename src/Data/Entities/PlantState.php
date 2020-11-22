<?php

  namespace App\Data\Entities;

  class PlantState
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
    public function __toString()
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