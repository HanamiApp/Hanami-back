<?php

  namespace App\Data\Entities;

  use App\Data\Entities\Interfaces\IEntity;
  require_once __DIR__ . '/interfaces/IEntity.php';

  Class Genus implements IEntity
  {

    private $id;
    private $name;
    private $pathImage;

    public function __constructor( $name = null, $pathImage = null ){
      $this->id = $name;
      $this->name = $name;
      $this->pathImage = $pathImage;
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
        'pathImage' => $this->pathImage
      ];
    }

   }
?>