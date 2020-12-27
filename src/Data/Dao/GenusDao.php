<?php

  namespace App\Data\Dao;

  use App\Resources\Config\Database as Database;
  use App\Data\Entities\Genus as Genus;
  use \PDO as PDO;
  use App\Services\HTTP;
  require_once __DIR__ . '/../../Services/HTTP.php';
  require_once __DIR__ . '/../Entities/Genus.php';
  require_once __DIR__ . '/../../../resources/config/Database.php';
  
  class GenusDao
  {

    private $connection;
    private $I_GENUS;
    private $S_BY_ID;
    
    public function __construct()
    {
      $Db = new Database();
      $this->connection = $Db->connect();
      $this->S_BY_ID = "SELECT * FROM `genus` WHERE `id`=:id";
    }

    private function generateGenus( $row )
    {
      if ( empty($row) ) return null;
      $Genus = new Genus();
      $Genus->id = (int)$row['id'];
      $Genus->name = $row['name'];
      $Genus->pathImage = $row['path_image'];
      return $Genus;
    }

    public function get( $id )
    {
      $stmt = $this->connection->prepare( $this->S_BY_ID );
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      HTTP::sendJsonResponse( 200, $this->generateGenus($row)->toArray() );
    }

  }
?>