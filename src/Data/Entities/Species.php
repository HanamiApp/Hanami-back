<?php

namespace App\Data\Entities;

  class Species
  {

    private $id;
    private $genus;
    private $name;
    private $co2;
    private $description;

    // constructor
    public function __construct( $genere = null, $nome = null, $co2 = null, $descrizione = null )
    {
      $this->id = null;
      $this->genere = $genere;
      $this->nome = $nome;
      $this->co2 = $co2;
      $this->description = $description;
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
  
    // ToString
    public function __toString()
    {
      return [
        'id' => $this->id, 
        'nome' => $this->name, 
        'genere' => $this->genus, 
        'co2' => $this->co2, 
        'descrizione' => $this->description
      ];
    }
    
   }