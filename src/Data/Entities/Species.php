<?php

namespace App\Data\Entities;

use App\Services\Logger;
use App\Data\Entities\Interfaces\IEntity;
require_once __DIR__ . '/interfaces/IEntity.php';
require_once __DIR__ . '/../../Services/Logger.php';

class Species implements IEntity
{

  private $id;
  private $idGenus;
  private $name;
  private $co2;
  private $description;
  private $fruit;

  // constructor
  public function __construct($idGenus = null, $name = null, $co2 = null, $description = null, $fruit = null)
  {
    $this->id = null;
    $this->idGenus = $idGenus;
    $this->name = $name;
    $this->co2 = $co2;
    $this->description = $description;
    $this->fruit = $fruit;
  }

  // __get and __set
  public function __get($variable)
  {
    return $this->$variable;
  }
  public function __set($variable, $value)
  {
    $this->$variable = $value;
  }

  // ToString
  public function __toString()
  {
    return [
      'id' => $this->id,
      'nome' => $this->name,
      'genere' => $this->idGenus,
      'albero_da_frutto' => $this->fruit,
      'co2' => $this->co2,
      'descrizione' => $this->description
    ];
  }

  // ToString
  public function toArray()
  {
    return [
      'id' => $this->id,
      'nome' => $this->name,
      'genere' => $this->idGenus,
      'albero_da_frutto' => $this->fruit,
      'co2' => $this->co2,
      'descrizione' => $this->description
    ];
  }
}
