<?php

  
  namespace App\Data\Entities;
  use App\Data\Enums\GroupEnum as GroupEnum;
  require_once __DIR__ . '/../Enums/GroupEnum.php';

  class Group
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


  }


?>