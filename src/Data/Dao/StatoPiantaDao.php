<?php 


  namespace App\Data\Dao;
  use App\Resources\Config\Database as Database;
  use \PDO as PDO;
  require_once __DIR__ . '/../../../resources/config/Database.php';

  class StatoPiantaDao{

   private $connection;
   private $I_STATUS;

   public function __construct()
   {
      $Db = new Database();
      $this->connection = $Db->connect();
      $this->I_STATUS = "INSERT INTO stato_pianta(stato, stato_vitale, giorno, id_pianta) VALUES(:stato, :stato_vitale, :giorno, :id_pianta)";
   }

   public function store($StatoPianta)
   {
      $stmt = $this->connection->prepare( $this->I_STATUS);

      $stmt->bindValue(':stato', $StatoPianta->getStato(), PDO::PARAM_STR);
      $stmt->bindValue(':stato_vitale', $StatoPianta->getStatoVitale(), PDO::PARAM_STR);
      $stmt->bindValue(':giorno', $StatoPianta->getGiorno(), PDO::PARAM_STR);
      $stmt->bindValue(':id_pianta', $StatoPianta->getIdPianta(), PDO::PARAM_STR);

      $stmt->execute();
      $StatoPianta->setId( $this->connection->lastInsertId());
   }


  }

?>