<?php

namespace App\Data\Entities;

class StatoPianta{

   private $id;
   private $stato;
   private $stato_vitale;
   private $giorno;

   public function __construct($stato, $stato_vitale, $giorno)
   {
      $this->id = null;
      $this->stato = $stato;
      $this->stato_vitale = $stato_vitale;
      $this->giorno = $giorno;
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

}

?>