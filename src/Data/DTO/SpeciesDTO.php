<?php

  namespace App\Data\DTO;

  class SpeciesDTO
  {

   public $id;
   public $name;
   public $idGenus;
   public $co2;
   public $fruit;
   public $description;

   public function __construct($Species)
   {
      $this->id = $Species->id;
      $this->name = $Species->name;
      $this->idGenus = $Species->idGenus;
      $this->co2 = $Species->co2;
      $this->description = $Species->description;
      $this->fruit = $Species->fruit;
   }

   public function toString()
   {
      return [
         'id_specie' => $this->id,
         'name_specie' => $this->name,
         'id_genus' => $this->idGenus,
         'albero_da_frutto' => $this->fruit,
         'co2' => $this->co2,
         'description' => $this->description
      ];
   }


  }
?>