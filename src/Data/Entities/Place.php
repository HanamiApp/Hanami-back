<?php

  namespace App\Data\Entities;

  use App\Data\Entities\Interfaces\IEntity;
  use App\Data\Enums\RegionEnum as RegionEnum;
  require_once __DIR__ . '/interfaces/IEntity.php';
  require_once __DIR__ . '/../Enums/RegionEnum.php';

  Class Place implements IEntity
  {

    private $id;
    private $name;
    private $city;
    private $region;
    Private $latitude;
    private $longitude;

    public function __construct($name = null, $city = null, $region = null, $latitude = null, $longitude = null)
    {
      $this->id = null;
      $this->name = $name;
      $this->city = $city;
      $this->region = $region;
      $this->latitude = $latitude;
      $this->longitude = $longitude;
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
        'id' => $this->id,
        'name' => $this->name,
        'city' => $this->city,
        'region' => $this->region,
        'latitude' => $this->latitude,
        'longitude' => $this->longitude
      ];
    }

  }
?>