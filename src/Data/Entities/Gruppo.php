<?php

  
  namespace App\Data\Entities;

  class Gruppo
  {

    private $id;
    private $nome;

    public function __contruct($nome = null)
    {
      $this->id = null;
      $this->nome = $nome;
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

  }


?>