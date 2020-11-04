<?php 


  namespace App\Data\Dao;
  use App\Resources\Config\Database as Database;
  use \PDO as PDO;use App\Data\Entities\Pianta;
  use App\Data\Models\StatoPianta as StatoPianta;
  use App\Data\Dao\PiantaDao as PiantaDao;
  use App\Data\Dao\StatoPiantaDao as StatoPiantaDao;
  use App\Controllers\QRCodeController as QRCodeController;
  require_once __DIR__ . '/../../../resources/config/Database.php';

  class StatoPiantaDao{

   private $connection;
   private $I_STATUS;

   public function __construct()
   {
      $db = new Database();
      $this->connection = $db->connect();
      $this->I_STATUS = "INSERT INTO stato_pianta(stato, stato_vitale, giorno, id_pianta) VALUES(:stato, :stato_vitale, :giorno, :id_pianta)";
      $this->S_PLANT_STATUS = "SELECT * FROM stato_pianta WHERE id_pianta = :id_pianta ;";
   }

   public function store($StatoPianta)
   {
      $stmt = $this->connection->prepare( $this->I_STATUS);

      $stmt->bindValue(':stato', $StatoPianta->getStato(), PDO::PARAM_STR);
      $stmt->bindValue(':stato_vitale', $StatoPianta->getStatoVitale(), PDO::PARAM_STR);
      $stmt->bindValue(':giorno', $StatoPianta->getGiorno(), PDO::PARAM_STR);
      $stmt->bindValue(':id_pianta', $StatoPianta->getId(), PDO::PARAM_STR);

      $stmt->execute();
      $StatoPianta->setIdStato($this->connection->lastInsertId());
   }

   public function getStatoPianta($Pianta)
   {
      $id = $Pianta->getId();
      $stmt = $this->connection->prepare($this->S_PLANT_STATUS);
      $stmt->bindValue(':id_pianta', $id, PDO::PARAM_STR);
      $stmt->execute();
      $StatoPiantaVector = $stmt->fetch(PDO::FETCH_ASSOC);
      $StatoPianta = new StatoPianta($Pianta->getGenere(), $Pianta->getSpecie(), $Pianta->getNome(), $Pianta->getCo2(), $Pianta->getDescrizione());
      $StatoPianta->setIdStato($StatoPiantaVector['id']);
      $StatoPianta->setStato($StatoPiantaVector['stato']);
      $StatoPianta->setStatoVitale($StatoPiantaVector['stato_vitale']);
      $StatoPianta->setGiorno($StatoPiantaVector['giorno']);
      $StatoPianta->setQRCode($Pianta->getQRCode());
      $StatoPianta->setId($Pianta->getId());

      return $StatoPianta;
   }

  }
?>