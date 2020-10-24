<?php

namespace App\Data\Entities;

  class Pianta
  {

    private $id;
    private $specie;
    private $nome;
    private $descrizione;
    private $genere;
    private $co2;
    private $qrcode;

    public function __construct($genere, $specie, $nome, $co2, $descrizione)
    {
      $this->id = null;
      $this->nome = $nome;
      $this->specie = $specie;
      $this->descrizione = $descrizione;
      $this->genere = $genere;
      $this->co2 = $co2;
    }

    // getters and setters
    // id
    public function getId()
    {
      return $this->id;
    }
    public function setId($id)
    {
      $this->id = $id;
    }

    // nome
    public function getNome()
    {
      return $this->nome;
    }
    public function setNome($nome)
    {
      $this->nome = $nome;
    } 

    // specie
    public function getSpecie()
    {
      return $this->specie;
    }
    public function setSpecie($specie)
    {
      $this->specie = $specie;
    }
       
    // genere
    public function getGenere()
    {
      return $this->genere;
    }
    public function setGenere($genere)
    {
      $this->genere = $genere;
    }
       
    // descrizione
    public function getDescrizione()
    {
      return $this->descrizione;
    }
    public function setDecrizione($descrizione)
    {
      $this->descrizione = $descrizione;
    }

    // co2
    public function getCo2()
    {
      return $this->co2;
    }
    public function setCo2($co2)
    {
      $this->co2 = $co2;
    }

    // qrcode
    public function getQRCode()
    {
      return $this->qrcode;
    }
    public function setQRCode($qrcode)
    {
      $this->qrcode = $qrcode;
    }
    
   }