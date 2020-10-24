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
      $this->I_PIANTA = "INSERT INTO stato_pianta(stato, stato_vitale, giorno) VALUES(:genere, :specie, :nome, :co2, :descrizione)";
   }


  }

?>