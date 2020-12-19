<?php

  namespace App\Data\Entities;

  use App\Data\Enums\RegionEnum as RegionEnum;
  require_once __DIR__ . '/../Enums/RegionEnum.php';

  Class Place{

    Private $id;
    Private $name;
    Private $city;
    Private $region;
    Private $coordinate;


    Public function __construct($name=null, $city=null, $region=null, $coordinate=null){

      $this->id = null;
      $this->name = $name;
      $this->city = $city;
      $this->region = $region;
      $this->coordinate = $coordinate;

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
        'name' => $this->name,
        'city' => $this->city,
        'region' => $this->region,
        'coordinate' => $this->coordinate
      ];
    }

  }
?>