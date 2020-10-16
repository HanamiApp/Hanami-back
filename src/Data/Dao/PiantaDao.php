<?php

  namespace App\Data\Dao;
  use App\Resources\Config\Database as Database;
  use \PDO as PDO;
  require_once __DIR__ . '/../../../resources/config/Database.php';

  class UtenteDao
  {

    private $connection;
    private $I_PLANT;
    private $S_PLANT;

    public function __construct()
    {
      $Db = new Database();
      $this->connection = $Db->connect();
      $this->I_PIANTA= "INSERT INTO pianta(genere, specie, nome, co2, descrizione) VALUES(:genere, :specie, :nome, :co2, :descrizione)";
    }

    public function store($Pianta)
    {
      $stmt = $this->connection->prepare( $this->I_PIANTA );
      $stmt->bindParam(':genere', $Pianta->getGenere(), PDO::PARAM_STR);
      $stmt->bindParam(':specie', $Pianta->getSpecie(), PDO::PARAM_STR);
      $stmt->bindParam(':nome', $Pianta->getNome(), PDO::PARAM_STR);
      $stmt->bindParam(':co2', $Pianta->getco2(), PDO::PARAM_STR);
      $stmt->bindParam(':descrizione', $Pianta->getDescrizione(), PDO::PARAM_STR);
      $stmt->execute();
      $Pianta->setId( $this->connection->lastInsertId() );
    }
  }