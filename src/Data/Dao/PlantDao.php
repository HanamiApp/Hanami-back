<?php

  namespace App\Data\Dao;

  use App\Resources\Config\Database as Database;
  use App\Data\Entities\Plant as Plant;
  use \PDO as PDO;
  use App\Services\Logger;
  require_once __DIR__ . '/../../Services/Logger.php';
  require_once __DIR__ . '/../../../resources/config/Database.php';
  
  class PlantDao
  {

    private $connection;
    private $S_TREE_BY_ID;
    private $I_PLANT;
    private $U_QR;
    private $S_ALL_PLANT;

    public function __construct()
    {
      $Db = new Database();
      $this->connection = $Db->connect();
      $this->I_PLANT = "INSERT INTO `plant`(`name`, `has_gift`, `id_place`, `id_plant_state`, `id_gift_state`, `id_user`, `id_species`) VALUES(:name, :has_gift, :id_place, :id_plant_state, :id_gift_state, :id_user, :id_species)";
      $this->S_TREE_BY_ID = "SELECT * FROM `plant` WHERE id=:id";
      $this->U_QR = "UPDATE plant SET `qrcode`=:qrcode WHERE `id`=:id";
      $this->S_ALL_PLANT = "SELECT * FROM `plant`";
    }

    public function generatePlant( $row )
    {
      if ( empty($row) ) return null;
      $Plant = new Plant();
      $Plant->id = $row['id'];
      $Plant->name = $row['name'];
      $Plant->hasGift = $row['has_gift'];
      $Plant->placeId = $row['id_place'];
      $Plant->plantStateId = $row['id_plant_state'];
      $Plant->giftStateId = $row['id_gift_state'];
      $Plant->userId = $row['id_user'];
      $Plant->speciesId = $row['id_species'];
      $Plant->qrCode = $row['qrcode'];
      return $Plant;
    }

    public function store( $Plant ) {
      if ( !isset($Plant) ) return null;
      $stmt = $this->connection->prepare( $this->I_PLANT );
      $stmt->bindValue(':name', $Plant->name, PDO::PARAM_STR);
      $stmt->bindValue(':has_gift', $Plant->hasGift, PDO::PARAM_INT);
      $stmt->bindValue(':id_place', $Plant->placeId, PDO::PARAM_INT);
      $stmt->bindValue(':id_plant_state', $Plant->plantStateId, PDO::PARAM_INT);
      $stmt->bindValue(':id_gift_state', $Plant->giftStateId, (null !== $Plant->giftStateId) ? PDO::PARAM_INT : PDO::PARAM_NULL);
      $stmt->bindValue(':id_user', $Plant->userId, PDO::PARAM_INT);
      $stmt->bindValue(':id_species', $Plant->speciesId, PDO::PARAM_INT);
      $stmt->execute();
      $Plant->id = $this->connection->lastInsertId();
    }

    public function getById( $id )
    {
      if ( empty($id) ) return null;
      $stmt = $this->connection->prepare( $this->S_TREE_BY_ID );
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
      return $this->generatePlant($row);
    }

    //***************** */
    public function getAll(){
      $array = array();
      $array = [];
      $result = $this->connection->query( $this->S_ALL_PLANT )->fetchAll(PDO::FETCH_ASSOC);
      
      
      foreach($result as $row){
          array_push( $array, $this->generatePlant($row) );
      }

      return $array;
    }

    public function getByUserId( $id )
    {
      if ( empty($id) || gettype($id) !== 'integer' ) return null;
      $stmt = $this->connection->prepare( $this->S_ALBERO_BY_USER );
      $stmt->bindParam(':id_utente', $id, PDO::PARAM_INT);
      $stmt->execute();
      return $this->generatePlant($stmt->fetch());
    }

    public function updateQRCode( $Plant )
    {
      if ( empty($Plant) ) return false;
      $stmt = $this->connection->prepare( $this->U_QR );
      $stmt->bindValue(':qrcode', $Plant->qrCode, PDO::PARAM_STR);
      $stmt->bindValue(':id', $Plant->id, PDO::PARAM_INT);
      $stmt->execute();
    }

  }


?>