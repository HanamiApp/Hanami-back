<?php

  namespace App\Data\Dao;

  use App\Resources\Config\Database as Database;
  use App\Services\Logger;
  use App\Data\Entities\Place;
  use \PDO as PDO;
  require_once __DIR__ . '/../Entities/Place.php';
  require_once __DIR__ . '/../../Services/Logger.php';
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
      $this->I_PLACE = "INSERT INTO `place`(`name`, `city`, `region`, `latitude`, `longitude`) VALUES(:name, :city, :region, :latitude, :longitude)";
      $this->S_PLACE = "SELECT * FROM `place`";
    }

    private function generatePlace( $row ) {
      if ( !isset( $row ) ) return null;
      $Place = new Place();
      $Place->id = (int)$row['id'];
      $Place->name = $row['name'];
      $Place->city = $row['city'];
      $Place->region = $row['region'];
      $Place->latitude = (float)$row['latitude'];
      $Place->longitude = (float)$row['longitude'];
      return $Place;
    }

    public function store( $array ) {
      $stmt = $this->connection->prepare( $this->I_PLACE );
      $name = "Bosco di " . $array['city'];
      $stmt->bindParam(':name', $name, PDO::PARAM_STR);
      $stmt->bindParam(':city', $array['city'], PDO::PARAM_STR);
      $stmt->bindParam(':region', $array['region'], PDO::PARAM_STR);
      $stmt->bindParam(':latitude', $array['latitude']);
      $stmt->bindParam(':longitude', $array['longitude']);
      $stmt->execute();
    }

    public function getAll()
    {
      $results = [];
      $stmt = $this->connection->prepare( $this->S_PLACE );
      $stmt->execute();
      while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        array_push($results, $this->generatePlace($row));
      }
      return $results;
    }

  }
?>