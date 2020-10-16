<?php


  namespace App\Data\Entities;
  use App\Data\Enums\RegioneEnum as RegioneEnum;
  require_once __DIR__ . '/../Enums/RegioneEnum.php';

  class Utente
  {

    private $id;
    private $nome;
    private $cognome;
    private $email;
    private $password;
    private $regione;

    public function __construct($nome, $cognome, $email, $password, $regione)
    {
      $this->id = null;
      $this->nome = $nome;
      $this->cognome = $cognome;
      $this->email = $email;
      $this->password = $password;
      $this->regione = $regione;
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
    public function setnome($nome)
    {
      $this->nome= $nome;
    }

    // cognome
    public function getCognome()
    {
      return $this->cognome;
    }
    public function setCognome($cognome)
    {
      $this->cognome= $cognome;
    }

    // email
    public function getEmail()
    {
      return $this->email;
    }
    public function setEmail($email)
    {
      $this->email= $email;
    }

    // password
    public function getPassword()
    {
      return $this->password;
    }
    public function setPassword($password)
    {
      $this->password= $password;
    }

    // regione
    public function getRegione()
    {
      return $this->regione;
    }
    public function setRegione($regione)
    {
      $this->regione= RegioneEnum::getValueOf($regione);
    }

  }


?>