<?php

  namespace App\Data\Dao;
  use App\Resources\Config\Database as Database;
  use \PDO as PDO;
  use App\Data\Entities\Species;
  use App\Data\Dao\PlantStateDao as PlantStateDao;
  use App\Controllers\QRCodeController as QRCodeController;
  use App\Services\Logger;
  require_once __DIR__ . '/../../Services/Logger.php';
  require_once __DIR__ . '/../../../resources/config/Database.php';
  require_once __DIR__ . '/../Entities/Species.php';


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
      $this->I_SPECIES = "INSERT INTO `species`(`id_genus`, `name`, `co2`, `fruit`, `fruit`, `description`) VALUES(:idGenus, :name, :co2, :fruit, :description)";
      $this->S_SPECIES = "SELECT * FROM `species`";
      $this->S_SPECIES_BY_ID = "SELECT * FROM `species` WHERE `id`=:id";
      $this->D_SPECIES_BY_ID = "DELETE FROM `species` WHERE `id`=:id";
    }


    public function generateSpecies( $row )
    {
      if ( !isset($row) ) return null;
      $Species = new Species();
      $Species->id = (int)$row['id'];
      $Species->idGenus = (int)$row['id_genus'];
      $Species->name = $row['name'];
      $Species->fruit = (bool)$row['fruit'];
      $Species->co2 = (float)$row['co2'];
      $Species->description = $row['description'];
      return $Species;
    }

    public function store( $Species )
    {
      $stmt = $this->connection->prepare( $this->I_SPECIES );
      $stmt->bindValue(':genus', $Species->genus, PDO::PARAM_STR);
      $stmt->bindValue(':name', $Species->name, PDO::PARAM_STR);
      $stmt->bindValue(':fruit', $Species->fruit, PDO::PARAM_INT);
      $stmt->bindValue(':co2', $Species->co2, PDO::PARAM_STR);
      $stmt->bindValue(':description', $Species->description, PDO::PARAM_STR);
      $stmt->execute();
      $Species->setId( $this->connection->lastInsertId() );
    }

    public function getAll()
    {
      $array = [];
      // $result = $this->connection->query($this->S_SPECIES)->fetchAll(PDO::FETCH_ASSOC);
      
      // foreach($result as $row)
      //     array_push( $array, $this->generateSpecies($row) );
      $stmt = $this->connection->prepare( $this->S_SPECIES );
      $stmt->execute();
      while( $row = $stmt->fetch() ) {
        array_push( $array, $this->generateSpecies($row) );
      }
      return $array;
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