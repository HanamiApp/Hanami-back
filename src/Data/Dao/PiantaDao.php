<?php

  namespace App\Data\Dao;
  use App\Resources\Config\Database as Database;
  use \PDO as PDO;
  use App\Data\Entities\Pianta;
  use App\Data\Models\StatoPianta as StatoPianta;
  use App\Data\Dao\PiantaDao as PiantaDao;
  use App\Data\Dao\StatoPiantaDao as StatoPiantaDao;
  use App\Controllers\QRCodeController as QRCodeController;

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
      $db = new Database();
      $this->connection = $db->connect();
      $this->I_PIANTA = "INSERT INTO pianta(genere, specie, nome, co2, descrizione) VALUES(:genere, :specie, :nome, :co2, :descrizione)";
      $this->D_PLANT = "DELETE FROM pianta WHERE id=:id";
      $this->U_QR_PLANT = "UPDATE pianta SET qrcode = :qrcode WHERE id = :id";
      $this->S_PLANT = "SELECT * FROM pianta WHERE id = :id ;";
      

    }

    public function store($Pianta)
    {
      $stmt = $this->connection->prepare( $this->I_PIANTA );

      $stmt->bindValue(':genere', $Pianta->getGenere(), PDO::PARAM_STR);
      $stmt->bindValue(':specie', $Pianta->getSpecie(), PDO::PARAM_STR);
      $stmt->bindValue(':nome', $Pianta->getNome(), PDO::PARAM_STR);
      $stmt->bindValue(':co2', $Pianta->getCo2(), PDO::PARAM_STR);
      $stmt->bindValue(':descrizione', $Pianta->getDescrizione(), PDO::PARAM_STR);
      
      $stmt->execute();
      $Pianta->setId( $this->connection->lastInsertId() );
    }

    public function delete($Pianta)
    {
      //
    }

    public function updateQRCode($Pianta)
    {
      $stmt = $this->connection->prepare($this->U_QR_PLANT);
      $stmt->bindValue(':qrcode', $Pianta->getQRCode(), PDO::PARAM_STR);
      $stmt->bindValue(':id', $Pianta->getId(), PDO::PARAM_STR);
      $stmt->execute();
    }

    public function getPianta($id)
    {
      $stmt = $this->connection->prepare($this->S_PLANT);
      $stmt->bindValue(':id', $id, PDO::PARAM_STR);
      $stmt->execute();
      $PiantaVector = $stmt->fetch(PDO::FETCH_ASSOC);

      $Pianta = new Pianta($PiantaVector['genere'], $PiantaVector['specie'], $PiantaVector['nome'], $PiantaVector['co2'], $PiantaVector['descrizione']);
      //setto i valori mancanti alla pianta che ho appena creato per restituire tutte le informazioni della pianta
      $Pianta->setId($PiantaVector['id']);
      $Pianta->setQRCode($PiantaVector['qrcode']);

      $StatoPiantaDao = new StatoPiantaDao();
      return $StatoPiantaDao->getStatoPianta($Pianta);
    }

  }