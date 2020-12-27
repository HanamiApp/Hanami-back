<?php

  namespace App\Data\DTO;

  class PlaceDTO
  {

    public $id;
    public $name;
    public $city;
    public $region;
    public $latitude;
    public $longitude;

    public function __construct( $PlaceEntity )
    {
      if ( !is_array($PlaceEntity) ) $PlaceEntity = $PlaceEntity->toArray();
      $this->id = $PlaceEntity['id'];
      $this->name = $PlaceEntity['name'];
      $this->city = $PlaceEntity['city'];
      $this->region = $PlaceEntity['region'];
      $this->latitude = $PlaceEntity['latitude'];
      $this->longitude = $PlaceEntity['longitude'];
    }

  }

?>