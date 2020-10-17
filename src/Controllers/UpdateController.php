<?php


  namespace App\Controllers;
  
  class UpdateController
  {

    private $id;
    private $data;
    private $ora;
    private $intervento;
    private $path_img;
    private $id_pianta;
    private $id_utente;

    public function __contruct($data, $ora, $intervento, $path_img, $id_pianta, $id_utente)
    {
      $this->id = null;
      $this->data = $data;
      $this->ora = $ora;
      $this->intervanto = $intervanto;
      $this->path_img = $path_img;
      $this->id_pianta = $id_pianta;
      $this->id_utente = $id_utente;
    }

    // getters and setters
    // id
    public function getId()
    {
      return $this->id;
    }
    public function setId()
    {
      return $this->id;
    }

    // data
    public function getData()
    {
      return $this->data;
    }
    public function setData()
    {
      return $this->data;
    }

    // ora
    public function getOra()
    {
      return $this->ora;
    }
    public function setOra()
    {
      return $this->ora;
    }

    // intervento
    public function getIntervento()
    {
      return $this->intervento;
    }
    public function setIntervento()
    {
      return $this->intervento;
    }

    // path_img
    public function getPathImg()
    {
      return $this->path_img;
    }
    public function setPathImg()
    {
      return $this->path_img;
    }

    // id_pianta
    public function getIdPianta()
    {
      return $this->id_pianta;
    }
    public function setIdPianta()
    {
      return $this->id_pianta;
    }

    // id_utente
    public function getIdUtente()
    {
      return $this->id_utente;
    }
    public function setIdUtente()
    {
      return $this->id_utente;
    }

  }


?>