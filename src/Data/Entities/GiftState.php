<?php

  
  namespace App\Data\Entities;

  class GiftState
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


  }


?>