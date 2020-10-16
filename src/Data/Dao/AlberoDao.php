<?php


  namespace App\Data\Dao;
  use App\Resources\Config\Database as Database;
  use \PDO as PDO;
  require_once __DIR__ . '/../../../resources/config/Database.php';
  
  class AlberoDao
  {

    private $connection;
    private $S_ALBERO_BY_USER_ID;

    public function __construct()
    {
      $Db = new Database();
      $this->connection = $Db->connect();
      $this->S_ALBERO_BY_USER_ID = "SELECT * FROM utente_pianta.*, pianta.* FROM utente_pianta JOIN pianta ON utente_pianta.id_pianta=pianta.id WHERE utente_pianta.id_utente=:id_utente";
    }

    public function getAlberoByUtenteId($id)
    {
      $stmt = $this->connection->prepare( $this->S_ALBERO_BY_USER );
      $stmt->bindParam(':id_utente', $id, PDO::PARAM_INT);
      $stm->execute();
      $res = $stmt->fetch();
      // TODO: usare il metodo per generare un oggetto anziche ritornare il resultset
      return $res;
    }

  }


?>