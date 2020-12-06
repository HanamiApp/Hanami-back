<?php 


  namespace App\Data\Dao;
  use App\Resources\Config\Database as Database;
  use \PDO as PDO;
  use App\Data\Models\PlantState as PlantState;
  require_once __DIR__ . '/../../../resources/config/Database.php';


  class PlantStateDao {

   private $connection;
   private $I_PLANT_STATE;

   public function __construct()
   {
      $db = new Database();
      $this->connection = $db->connect();
      $this->I_PLANT_STATE = "INSERT INTO `plant_state`(`state`, `condition`, `day`) VALUES(:state, :condition, :day)";
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

   // public function getStatoPianta($Pianta)
   // {
   //    $id = $Pianta->getId();
   //    $stmt = $this->connection->prepare($this->S_PLANT_STATUS);
   //    $stmt->bindValue(':id_pianta', $id, PDO::PARAM_STR);
   //    $stmt->execute();
   //    $StatoPiantaVector = $stmt->fetch(PDO::FETCH_ASSOC);
   //    $PlantState = new PlantState($Pianta->getGenere(), $Pianta->getSpecie(), $Pianta->getNome(), $Pianta->getCo2(), $Pianta->getDescrizione());
   //    $PlantState->setIdStato($StatoPiantaVector['id']);
   //    $PlantState->setStato($StatoPiantaVector['stato']);
   //    $PlantState->setStatoVitale($StatoPiantaVector['stato_vitale']);
   //    $PlantState->setGiorno($StatoPiantaVector['giorno']);
   //    $PlantState->setQRCode($Pianta->getQRCode());
   //    $PlantState->setId($Pianta->getId());

   //    return $PlantState;
   // }

  }
?>