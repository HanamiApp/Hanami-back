<?php

namespace App\Data\Entities;

class StatoPianta{

   private $id;
   private $stato;
   private $stato_vitale;
   private $giorno;
   private $id_pianta;

   public function __construct()
   {
      $this->id = null;
      $this->stato = 'trasporto';
      $this->stato_vitale = 'buono stato';
      //$this->giorno = date("d/m/Y");
      $this->giorno = date("Y/m/d");
   }

   // id
    public function getId()
    {
      return $this->id;
    }
    public function setId($id)
    {
      $this->id = $id;
    }

    /// stato
    public function getStato()
    {
      return $this->stato;
    }
    public function setStato($stato)
    {
      $this->stato = $stato;
    }

    // stato_vitale
    public function getStatoVitale()
    {
      return $this->stato_vitale;
    }
    public function setStatoVitale($stato_vitale)
    {
      $this->stato_vitale = $stato_vitale;
    }

    // giorno
    public function getGiorno()
    {
      return $this->giorno;
    }
    public function setGiorno($giorno)
    {
      $this->giorno = $giorno;
    }

    // id_pianta
    public function getIdPianta()
    {
      return $this->id_pianta;
    }
    public function setIdPianta($id_pianta)
    {
      $this->id_pianta = $id_pianta;
    }

}

?>