<?php 


  namespace App\Data\Dao;
  use App\Resources\Config\Database as Database;
  use App\Data\Entities\PlantState as PlantState;
  use \PDO as PDO;
  require_once __DIR__ . '/../../../resources/config/Database.php';
  require_once __DIR__ . '/../Entities/PlantState.php';



  class PlantStateDao {

   private $connection;
   private $I_PLANT_STATE;
   private $S_PLANT_STATE_BY_ID;
   private $S_ALL_PLANT_STATE;

   public function __construct()
   {
      $db = new Database();
      $this->connection = $db->connect();
      $this->S_PLANT_STATE_BY_ID = "SELECT * FROM `plant_state` WHERE `id` = :id";
      $this->S_ALL_PLANT_STATE = "SELECT * from `plant_state`";
      $this->I_PLANT_STATE = "INSERT INTO `plant_state`(`state`, `condition`, `day`) VALUES(:state, :condition, :day)";
   }

   public function generatePlantState($row)
   {
      if ( empty($row) ) return null;
      $PlantState = new PlantState();
      $PlantState->id = $row['id'];
      $PlantState->condition = $row['condition'];
      $PlantState->state = $row['state'];
      $PlantState->day = $row['day'];

      return $PlantState;
   }

   public function store( $PlantState )
   {
      $stmt = $this->connection->prepare( $this->I_PLANT_STATE);
      $stmt->bindValue(':state', $PlantState->state, PDO::PARAM_STR);
      $stmt->bindValue(':condition', $PlantState->condition, PDO::PARAM_STR);
      $stmt->bindValue(':day', $PlantState->day, PDO::PARAM_STR);
      $stmt->execute();
      $PlantState->id = $this->connection->lastInsertId();
   }

   public function getById( $id )
   {
      $stmt = $this->connection->prepare( $this->S_PLANT_STATE_BY_ID);
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
      return $this->generatePlantState($row);
   }

   public function getAll()
   {
      $array = array();
      $array = [];
      $result = $this->connection->query( $this->S_ALL_PLANT_STATE )->fetchAll(PDO::FETCH_ASSOC);

      foreach($result as $row){
          array_push( $array, $this->generatePlantState($row) );
      }

      return $array;
   }

  }
?>