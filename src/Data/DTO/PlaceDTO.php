<?php

  namespace App\Data\DTO;

  use App\Data\Enums\RegionEnum;
  require_once __DIR__ . '/../Enums/RegionEnum.php';

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
      $this->region = RegionEnum::getValueOf($PlaceEntity['region']);
      $this->latitude = $PlaceEntity['latitude'];
      $this->longitude = $PlaceEntity['longitude'];
    }

  }

?>