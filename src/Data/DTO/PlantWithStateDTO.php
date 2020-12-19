<?php

  namespace App\Data\DTO;

  class PlantWithStateDTO{

   public $plantId;
   public $name;
   public $hasGift;
   public $placeId;
   public $giftStateId;
   public $userId;
   public $speciesId;
   public $qrcode;
   public $plantStateId;
   public $state;
   public $condition;
   public $day;

   public function __construct($Plant, $PlantState)
   {
      $this->plantId = $Plant->id;
      $this->name = $Plant->name;
      $this->hasGift = $Plant->hasGift;
      $this->placeId = $Plant->placeId;
      $this->giftStateId = $Plant->giftStateId;
      $this->userId = $Plant->userId;
      $this->speciesId = $Plant->speciesId;
      $this->qrcode = $Plant->qrCode;
      $this->plantStateId = $PlantState->id;
      $this->state= $PlantState->state;
      $this->condition = $PlantState->condition;
      $this->day = $PlantState->day;
   }

   public function toString(){
      return [
         'id_plant' => $this->plantId,
        'name_plant' => $this->name,
        'has_gift' => $this->hasGift,
        'place_id' => $this->placeId,
        'gift_state_id' => $this->giftStateId,
        'user_id' => $this->userId,
        'species_id' => $this->speciesId,
        'qrcode' => $this->qrcode,
        'plant_state_id' => $this->plantStateId,
        'state_plant' => $this->state,
        'state_condition' => $this->condition,
        'day_planted' => $this->day
      ];
   }

}
?>