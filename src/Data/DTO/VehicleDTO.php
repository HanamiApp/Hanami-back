<?php

  namespace App\Data\DTO;

  use App\Data\Entities\Vehicle;
  require_once __DIR__ . '/../Entities/Vehicle.php';

  class VehicleDTO
  {

    public $id;
    public $name;
    public $co2_multiplier;

    public function __construct( $VehicleEntity ) {
      if ( !is_array($VehicleEntity) ) $VehicleEntity = $VehicleEntity->toArray();
      $this->id = $VehicleEntity['id'];
      $this->name = $VehicleEntity['name'];
      $this->co2_multiplier = $VehicleEntity['co2_multiplier'];
    }

    public function toEntity() {
      $Entity = new Vehicle();
      $Entity->id = $this->id;
      $Entity->name = $this->name;
      $Entity->co2_multiplier = $this->co2_multiplier;
      return $Entity;
    }

    public function toFilledEntity( $VehicleEntity ) {
      $Entity = new Vehicle();
      $Entity->id = $VehicleEntity->id;
      $Entity->name = $this->name ?? $VehicleEntity->name;
      $Entity->co2_multiplier = $this->co2_multiplier ?? $VehicleEntity->co2_multiplier;
      return $Entity;
    }

  }

?>