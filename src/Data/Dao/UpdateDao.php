<?php


  namespace App\Data\Dao;
  use App\Resources\Config\Database as Database;
  use App\Data\Entities\Update as Update;
  use \PDO as PDO;
  require_once __DIR__ . '/../../../resources/config/Database.php';
  require_once __DIR__ . '/../Entities/Update.php';
  

  class UpdateDao
  {

    private $connection;
    private $S_UPDATE_BY_TREE_ID;

    public function __construct()
    {
      $Db = new Database();
      $this->connection = $Db->connect();
      $this->S_UPDATE_BY_TREE_ID = "SELECT * FROM `update` WHERE `id_plant`=:id_plant";
    }

    public function generateUpdate( $row )
    {
      if ( empty($row) ) return null;
      $Update = new Update();
      $Update->id = $row['id'];
      $Update->date = $row['date'];
      $Update->hour = $row['hour'];
      $Update->operation = $row['operation'];
      $Update->pathImg = $row['path_img'];
      $Update->plantId = $row['id_plant'];
      $Update->userId = $row['id_user'];
      return $Update;
    }

    public function getUpdatesByPlantId( $id )
    {
      if ( empty($id) ) return null;
      $updateLis = Array();
      $stmt = $this->connection->prepare( $this->S_UPDATE_BY_TREE_ID );
      $stmt->bindParam(':id_plant', $id, PDO::PARAM_INT);
      $stmt->execute();
      while ( $row = $stmt->fetch() ) {
        array_push($updateLis, $this->generateUpdate($row));
      }
      return $updateLis;
    }

  }


?>