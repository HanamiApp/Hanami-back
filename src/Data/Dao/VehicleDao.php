<?php

  namespace App\Data\Dao;

  use App\Resources\Config\Database;
  use App\Data\Entities\Vehicle;
  use \PDO as PDO;
  use App\Services\Logger;
  require_once __DIR__ . '/../../Services/Logger.php';
  require_once __DIR__ . '/../Entities/Vehicle.php';
  require_once __DIR__ . '/../../../resources/config/Database.php';

  class VehicleDao
  {
    
    private $connection;
    private $S_ALL, $S_BY_ID, $S_BY_NAME;
    private $INSERT;
    private $D_BY_ID;
    private $UPDATE;

    public function __construct()
    {
      $Db = new Database();
      $this->connection = $Db->connect();
      // queries
      $this->S_ALL = "SELECT * FROM `vehicle`";
      $this->S_BY_ID = "SELECT * FROM `vehicle` WHERE id=:id";
      $this->S_BY_NAME = "SELECT * FROM `vehicle` WHERE `name`=:name";
      $this->INSERT = "INSERT INTO `vehicle`(`name`, `co2_multiplier`) VALUES(:name, :co2_multiplier)";
      $this->D_BY_ID = "DELETE FROM `vehicle` WHERE id=:id";
      $this->UPDATE = "UPDATE `vehicle` SET `name`=:name, `co2_multiplier`=:co2_multiplier  WHERE id=:id";
    }

    private function generateVehicle( $row )
    {
      if ( $row === false ) return null;
      $Vehicle = new Vehicle();
      $Vehicle->id = (int)$row['id'];
      $Vehicle->name = $row['name'];
      $Vehicle->co2_multiplier = (float)$row['co2_multiplier'];
      return $Vehicle;
    }

    public function getAll()
    {
      $stmt = $this->connection->prepare( $this->S_ALL );
      $stmt->execute();
      $Vehicles = [];
      while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        array_push( $Vehicles, $this->generateVehicle($row) );
      }
      return $Vehicles;
    }

    public function getById( $id )
    {
      if ( !isset($id) ) return null;
      $stmt = $this->connection->prepare( $this->S_BY_ID );
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      return $this->generateVehicle( $stmt->fetch(PDO::FETCH_ASSOC) );
    }

    public function getByName( $name )
    {
      if ( !isset($name) ) return null;
      $stmt = $this->connection->prepare( $this->S_BY_NAME );
      $stmt->bindParam(':name', $name, PDO::PARAM_STR);
      $stmt->execute();
      return $this->generateVehicle( $stmt->fetch(PDO::FETCH_ASSOC) );
    }

    public function store( $Vehicle )
    {
      if ( !isset($Vehicle) ) return false;
      $stmt = $this->connection->prepare( $this->INSERT );
      $stmt->bindParam(':name', $Vehicle->name, PDO::PARAM_STR);
      $stmt->bindParam(':co2_multiplier', $Vehicle->co2_multiplier);
      $outcome = $stmt->execute();
      $Vehicle->id = $this->connection->lastInsertId();
      return $outcome;
    }

    public function delete( $id )
    {
      if ( !isset($id) ) return false;
      $stmt = $this->connection->prepare( $this->D_BY_ID );
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $outcome = $stmt->execute();
      return $outcome;
    }

    public function update( $Vehicle )
    {
      if ( !isset($Vehicle) ) return false;
      $stmt = $this->connection->prepare( $this->UPDATE );
      $stmt->bindParam(':name', $Vehicle->name, PDO::PARAM_STR);
      $stmt->bindParam(':co2_multiplier', $Vehicle->co2_multiplier);
      $stmt->bindParam(':id', $Vehicle->id, PDO::PARAM_INT);
      $outcome = $stmt->execute();
      return $outcome;
    }

  }

?>