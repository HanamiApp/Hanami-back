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
      $this->S_UPDATE_BY_TREE_ID = "SELECT * FROM aggiornamento WHERE id_pianta=:id_tree";
    }

    public function generateUpdate($row)
    {
      if ( empty($row) ) return null;
      $Update = new Update();
      $Update->setId($row['id']);
      $Update->setData($row['data']);
      $Update->setOra($row['ora']);
      $Update->setIntervento($row['intervento']);
      $Update->setPathImg($row['path_img']);
      $Update->setIdPianta($row['id_pianta']);
      $Update->setIdUtente($row['id_utente']);
      return $Update;
    }

    public function getUpdatesByTreeId($id)
    {
      if ( empty($id) ) return null;
      $updateLis = Array();
      $stmt = $this->connection->prepare( $this->S_UPDATE_BY_TREE_ID );
      $stmt->bindParam(':id_tree', $id, PDO::PARAM_INT);
      $stmt->execute();
      while ( $row = $stmt->fetch() ) {
        array_push($updateLis, $this->generateUpdate($row));
      }
      return $updateLis;
    }

  }


?>