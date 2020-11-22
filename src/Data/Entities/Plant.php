<?php

  namespace App\Data\Entities;

  class Plant
  {

    private $id;
    private $name;
    private $hasGift;
    private $placeId;
    private $plantStateId;
    private $giftStateId;
    private $userId;
    private $speciesId;
    private $qrCode;

    // constructor
    public function __construct( $name = null, $hasGift = null, $placeId = null, $plantStateId = null, $giftStateId = null, $userId = null, $speciesId = null, $qrCode = null ) {
      $this->id = null;
      $this->name = $name;
      $this->hasGift = $hasGift;
      $this->placeId = $placeId;
      $this->plantStateId = $plantStateId;
      $this->giftStateId = $giftStateId;
      $this->userId = $userId;
      $this->speciesId = $speciesId;
      $this->qrCode = $qrCode;
    }

    // magic methods __get and __set
    public function __get( $variable )
    {
      return $this->$variable;
    }
    public function __set( $variable, $value )
    {
      $this->$variable = $value;
    }

    // toString
    public function __toString() 
    {
      return [
        'id' => $this->id,
        'name' => $this->name,
        'hasGift' => $this->hasGift,
        'placeId' => $this->placeId,
        'plantStateId' => $this->plantStateId,
        'giftStateId' => $this->giftStateId,
        'userId' => $this->userId,
        'speciesId' => $this->speciesId,
        'qrCode' => $this->qrCode
      ];
    }


  }


?>