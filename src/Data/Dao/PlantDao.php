<?php

  namespace App\Data\Dao;

  use App\Resources\Config\Database as Database;
  use App\Data\Entities\Plant as Plant;
  use \PDO as PDO;
  require_once __DIR__ . '/../../../resources/config/Database.php';
  
  class PlantDao
  {

    private $connection;
    private $S_TREE_BY_ID;
    private $S_ALBERO_BY_USER_ID;
    private $U_QR;

    public function __construct()
    {
      $Db = new Database();
      $this->connection = $Db->connect();
      $this->I_PLANT = "INSERT INTO `plant`(`name`, `has_gift`, `id_place`, `id_plant_state`, `id_gift_state`, `id_user`, `id_species`) VALUES(:name, :has_gift, :id_place, :id_plant_state, :id_gift_state, :id_user, :id_species)";
      $this->S_TREE_BY_ID = "SELECT * FROM `plant` WHERE id=:id_tree";
      $this->U_QR = "UPDATE plant SET `qr_code`=:qr_core WHERE `id_plant`=:id_plant";
      // TODO: riscrivere join
      //$this->S_ALBERO_BY_USER_ID = "SELECT * FROM `plant`.*, `plant`.* FROM `plant` JOIN `plant` ON `plant`.id_pianta=pianta.id WHERE utente_pianta.id_utente=:id_utente";
    }

    public function generatePlant( $row )
    {
      if ( !isset($row) ) return null;
      $Plant = new Plant();
      $Plant->id = $row['id'];
      $Plant->name = $row['name'];
      $Plant->hasGift = $row['has_gift'];
      $Plant->placeId = $row['id_place'];
      $Plant->plantStateId = $row['id_plant_state'];
      $Plant->giftStateId = $row['id_gift_state'];
      $Plant->userId = $row['id_user'];
      $Plant->speciesId = $row['id_species'];
      return $Plant;
    }

    public function store( $Plant ) {
      if ( !isset($Plant) ) return null;
      $stmt = $this->connection->prepare( $this->I_PLANT );
      $stmt->bindParam(':name', $Plant->name, PDO::PARAM_STR);
      $stmt->bindParam(':has_gift', $Plant->hasGift, PDO::PARAM_INT);
      $stmt->bindParam(':id_place', $Plant->placeId, PDO::PARAM_INT);
      $stmt->bindParam(':id_plant_state', $Plant->plantStateId, PDO::PARAM_INT);
      $stmt->bindParam(':id_gift_state', $Plant->giftStateId, (null !== $Plant->giftStateId) ? PDO::PARAM_INT : PDO::PARAM_NULL);
      $stmt->bindParam(':id_user', $Plant->userId, PDO::PARAM_INT);
      $stmt->bindParam(':id_species', $Plant->speciesId, PDO::PARAM_INT);
      $stmt->execute();
      $Plant->id = $this->connection->lastInsertId();
    }

    public function getById( $id )
    {
      if ( empty($id) ) return null;
      $stmt = $this->connection->prepare( $this->S_TREE_BY_ID );
      $stmt->bindParam(':id_tree', $id, PDO::PARAM_INT);
      $stmt->execute();
      return $this->generatePlant($stmt->fetch());
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
      $stmt->bindParam(':qr_code', $Plant->qrCode, PDO::PARAM_STR);
      $stmt->bindParam(':id_plant', $Plant->id, PDO::PARAM_INT);
      $stmt->execute();
    }

  }


?>