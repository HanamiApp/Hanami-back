<?php

  namespace App\Data\Dao;

  use App\Resources\Config\Database as Database;
  use App\Data\Entities\Plant as Genus;
  use \PDO as PDO;
  require_once __DIR__ . '/../../../resources/config/Database.php';
  
  class GenusDao
  {

    private $connection;
    private $I_GENUS;
    
    public function __construct()
    {
      $Db = new Database();
      $this->connection = $Db->connect();
      $this->I_GENUS = "INSERT INTO `genus`(`name`) VALUES(:name)";
    }

    public function store( $Genus ) {
      if ( !isset($Genus) ) return null;
      $stmt = $this->connection->prepare( $this->I_GENUS );
      $stmt->bindParam(':name', $Plant->name, PDO::PARAM_STR);
      $stmt->execute();
      $Place->id = $this->connection->lastInsertId();
    }
  }
?>