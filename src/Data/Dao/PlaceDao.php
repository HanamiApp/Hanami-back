<?php

  namespace App\Data\Dao;

  use App\Resources\Config\Database as Database;
  use App\Data\Entities\Plant as Plant;
  use \PDO as PDO;
  require_once __DIR__ . '/../../../resources/config/Database.php';
  
  class PlaceDao
  {

    private $connection;
    private $I_PLACE;
    private $S_PLACE;

    public function __construct()
    {
      $Db = new Database();
      $this->connection = $Db->connect();
      $this->I_PLACE = "INSERT INTO `place`(`name`, `city`, `region`, `coordinate`) VALUES(:name, :city, :region, :coordinate)";
    }

    public function store( $Place ) {
      if ( !isset($Place) ) return null;
      $stmt = $this->connection->prepare( $this->I_PLACE );
      $stmt->bindParam(':name', $Plant->name, PDO::PARAM_STR);
      $stmt->bindParam(':city', $Plant->hasGift, PDO::PARAM_INT);
      $stmt->bindParam(':region', $Plant->placeId, PDO::PARAM_INT);
      $stmt->bindParam(':coordinate', $Plant->plantStateId, PDO::PARAM_INT);
      $stmt->execute();
      $Place->id = $this->connection->lastInsertId();
    }
  }
?>