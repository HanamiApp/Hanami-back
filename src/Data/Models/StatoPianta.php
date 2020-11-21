<?php

namespace App\Data\Models;
use App\Data\Entities\Pianta;
require_once __DIR__ . '/../Entities/Pianta.php';

class StatoPianta extends Pianta{

   private $id_stato;
   private $stato;
   private $stato_vitale;
   private $giorno;

   public function __construct($genere, $specie, $nome, $co2, $descrizione)
   {
      parent::__construct($genere, $specie, $nome, $co2, $descrizione);
      $this->id_stato = null;
      $this->stato = 'trasporto';
      $this->stato_vitale = 'buono stato';
      $this->giorno = date("Y/m/d");
   }

   //id
   public function getIdStato(){
      return $this->id_stato;
   }

   public function setIdStato($id){
      $this->id_stato = $id;
   }

   //stato
   public function getStato(){
      return $this->stato;
   }

   public function setStato($stato){
      $this->stato = $stato;
   }

   //stato vitale
   public function getStatoVitale(){
      return $this->stato_vitale;
   }

   public function setStatoVitale($stato_vitale){
      $this->stato_vitale = $stato_vitale;
   }

   //giorno
   public function getGiorno(){
      return $this->giorno;
   }

   public function setGiorno($giorno){
      $this->giorno = $giorno;
   }

   public function __toString()
    {
      $array = ['id_stato' => $this->getIdStato(), 'stato' => $this->getStato(), 'stato_vitale' => $this->getStatoVitale(), 'giorno' => $this->getGiorno()];
      return  array_merge(parent::__toString(), $array);
    }

}

?>