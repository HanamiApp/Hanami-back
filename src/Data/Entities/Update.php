<?php


  namespace App\Data\Entities;
  
  
  class Update
  {

    private $id;
    private $data;
    private $ora;
    private $intervento;
    private $path_img;
    private $id_pianta;
    private $id_utente;

    public function __construct($data = null, $ora = null, $intervento = null, $path_img = null, $id_pianta = null, $id_utente = null)
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
    public function setId($id)
    {
      $this->id = $id;
    }

    // data
    public function getData()
    {
      return $this->data;
    }
    public function setData($data)
    {
      $this->data = $data;
    }

    // ora
    public function getOra()
    {
      return $this->ora;
    }
    public function setOra($ora)
    {
      $this->ora = $ora;
    }

    // intervento
    public function getIntervento()
    {
      return $this->intervento;
    }
    public function setIntervento($intervento)
    {
      $this->intervento = $intervento;
    }

    // path_img
    public function getPathImg()
    {
      return $this->path_img;
    }
    public function setPathImg($path_img)
    {
      $this->path_img = $path_img;
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

    // id_utente
    public function getIdUtente()
    {
      return $this->id_utente;
    }
    public function setIdUtente($id_utente)
    {
      $this->id_utente = $id_utente;
    }

    // toString
    public function __toString()
    {
      $description = [
        'id' => $this->id,
        'data' => $this->data,
        'ora' => $this->ora,
        'intervento' => $this->intervento,
        'path_img' => $this->path_img,
        'id_pianta' => $this->id_pianta,
        'id_utente' => $this->id_utente
      ];
      return json_encode($description);
    }

  }


?>