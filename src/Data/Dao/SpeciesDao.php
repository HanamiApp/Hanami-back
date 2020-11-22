<?php

  namespace App\Data\Dao;
  use App\Resources\Config\Database as Database;
  use \PDO as PDO;
  use App\Data\Entities\Species;
  use App\Data\Dao\PlantStateDao as PlantStateDao;
  use App\Controllers\QRCodeController as QRCodeController;

  require_once __DIR__ . '/../../../resources/config/Database.php';


  class SpeciesDao
  {

    private $connection;
    private $I_SPECIES;
    private $S_SPECIES, $S_SPECIES_BY_ID;
    private $D_SPECIES_BY_ID;
  
    public function __construct()
    {
      $db = new Database();
      $this->connection = $db->connect();
      $this->I_SPECIES = "INSERT INTO `species`(`genus`, `name`, `co2`, `description`) VALUES(:genus, :name, :co2, :description)";
      $this->S_SPECIES = "SELECT * FROM `species`";
      $this->S_SPECIES_BY_ID = "SELECT * FROM `species` WHERE `id`=:id";
      $this->D_SPECIES_BY_ID = "DELETE FROM `species` WHERE `id`=:id";
    }


    public function generateSpecies( $row )
    {
      if ( !isset($row) ) return null;
      $Species = new Species();
      $Species->id = $row['id'];
      $Species->genus = $row['genus'];
      $Species->name = $row['name'];
      $Species->co2 = $row['co2'];
      $Species->description = $row['description'];
      return $Species;
    }

    public function store( $Species )
    {
      $stmt = $this->connection->prepare( $this->I_SPECIES );
      $stmt->bindValue(':genus', $Species->genus, PDO::PARAM_STR);
      $stmt->bindValue(':name', $Species->name, PDO::PARAM_STR);
      $stmt->bindValue(':co2', $Species->co2, PDO::PARAM_STR);
      $stmt->bindValue(':description', $Species->description, PDO::PARAM_STR);
      $stmt->execute();
      $Species->setId( $this->connection->lastInsertId() );
    }

    public function delete( $Species )
    {
      //
    }

    public function updateQRCode( $Species )
    {
      $stmt = $this->connection->prepare($this->U_QR_PLANT);
      $stmt->bindValue(':qrcode', $Species->qrCode, PDO::PARAM_STR);
      $stmt->bindValue(':id', $Species->id, PDO::PARAM_STR);
      $stmt->execute();
    }

    public function getById( $id )
    {
      $stmt = $this->connection->prepare($this->S_PLANT);
      $stmt->bindValue(':id', $id, PDO::PARAM_STR);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      return $this->generateSpecies($row);
    }

    
  }