<?php

  namespace App\Data\Entities;

  class User
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
    public function getId()
    {
      return $this->id;
    }
    public function setId($id)
    {
      $this->id = $id;
    }

    public function getNome()
    {
      return $this->nome;
    }
    public function setnome($nome)
    {
      $this->nome= $nome;
    }

    public function getCognome()
    {
      return $this->cognome;
    }
    public function setCognome($cognome)
    {
      $this->cognome= $cognome;
    }

    public function getEmail()
    {
      return $this->email;
    }
    public function setEmail($email)
    {
      $this->email= $email;
    }

    public function getPassword()
    {
      return $this->password;
    }
    public function setPassword($password)
    {
      $this->password= $password;
    }

    public function getRegione()
    {
      return $this->regione;
    }
    public function setRegione($regione)
    {
      $this->regione= $regione;
    }

  }


?>