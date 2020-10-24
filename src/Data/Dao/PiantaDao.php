<?php

  namespace App\Data\Dao;
  use App\Resources\Config\Database as Database;
  use \PDO as PDO;
  require_once __DIR__ . '/../../../resources/config/Database.php';

  class PiantaDao
  {

    private $connection;
    private $I_PLANT;
    private $S_PLANT;
    private $D_PLANT;
    private $U_QR_PLANT;

    public function __construct()
    {
      $Db = new Database();
      $this->connection = $Db->connect();
      $this->I_PIANTA = "INSERT INTO pianta(genere, specie, nome, co2, descrizione) VALUES(:genere, :specie, :nome, :co2, :descrizione)";
      $this->D_PLANT = "DELETE FROM pianta WHERE id=:id";
      $this->U_QR_PLANT = "UPDATE pianta SET qrcode = :qrcode WHERE id = :id";
    }

    public function store($Pianta)
    {
      $stmt = $this->connection->prepare( $this->I_PIANTA );

      $stmt->bindValue(':genere', $Pianta->getGenere(), PDO::PARAM_STR);
      $stmt->bindValue(':specie', $Pianta->getSpecie(), PDO::PARAM_STR);
      $stmt->bindValue(':nome', $Pianta->getNome(), PDO::PARAM_STR);
      $stmt->bindValue(':co2', $Pianta->getCo2(), PDO::PARAM_STR);
      $stmt->bindValue(':descrizione', $Pianta->getDescrizione(), PDO::PARAM_STR);
      //file_put_contents('/Users/simone/Desktop/Hanami/Hanami-back/src/Debug/debug.txt', print_r($stmt->execute(), true), FILE_APPEND);
      $stmt->execute();
      $Pianta->setId( $this->connection->lastInsertId() );
    }

    public function delete($Pianta)
    {
      //da testare quando mi serve
      $stmt = $this->connection->prepare( $this->D_PIANTA );
      $stmt->bindParam(':id', $Pianta->getId(), PDO::PARAM_STR);
      $stmt->execute();
    }

    public function updateQRCode($Pianta)
    {
      $stmt = $this->connection->prepare($this->U_QR_PLANT);
      $stmt->bindValue(':qrcode', $Pianta->getQRCode(), PDO::PARAM_STR);
      $stmt->bindValue(':id', $Pianta->getId(), PDO::PARAM_STR);
      $stmt->execute();
    }

  }