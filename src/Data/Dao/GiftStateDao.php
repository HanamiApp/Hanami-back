<?php


  namespace App\Data\Dao;

  use App\Resources\Config\Database as Database;
  use App\Data\Entities\GiftState as GiftState;
  use \PDO as PDO;
  require_once __DIR__ . '/../../../resources/config/Database.php';
  require_once __DIR__ . '/../Entities/GiftState.php';


  class GiftStateDao
  {

    private $connection;
    private $I_STATE;

    public function __construct()
    {
      $Db = new Database();
      $this->connection = $Db->connect();
      $this->I_STATE = "INSERT INTO `gift_state`(`state`) VALUES(:state)";
    }

    public function store( $GiftState )
    {
      if ( empty($GiftState) ) return false;
      $stmt = $this->connection->prepare( $this->I_STATE );
      $stmt->bindParam(':state', $GiftState->state, PDO::PARAM_STR);
      $stmt->execute();
      $GiftState->id = $this->connection->lastInsertId();
      return true;
    }

  }


?>