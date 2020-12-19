<?php

  namespace App\Data\Entities;

  Class Genus{

    Private $id;
    Private $name;

    Public function __constructor($name = null){
       $this->id = null;
       $this->name = null;
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
    public function __toString()
    {
      return [
        'id' => $this->id,
        'name' => $this->name
      ];
    }

   }
?>