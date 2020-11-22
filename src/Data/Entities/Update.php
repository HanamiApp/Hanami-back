<?php


  namespace App\Data\Entities;
  
  
  class Update
  {

    private $id;
    private $date;
    private $hour;
    private $operation;
    private $pathImg;
    private $plantId;
    private $userId;

    // constructor
    public function __construct( $date = null, $hour = null, $operation = null, $pathImg = null, $plantId = null, $userId = null )
    {
      $this->id = null;
      $this->date = $date;
      $this->hour = $hour;
      $this->operation = $operation;
      $this->pathImg = $pathImg;
      $this->plantId = $plantId;
      $this->userId = $userId;
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

    // toString
    public function __toString()
    {
      return [
        'id' => $this->id,
        'date' => $this->date,
        'hour' => $this->hour,
        'operation' => $this->operation,
        'pathImg' => $this->pathImg,
        'plantId' => $this->plantId,
        'userId' => $this->userId
      ];
    }

  }


?>