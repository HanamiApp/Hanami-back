<?php


  namespace App\Data\Dao;
  use App\Resources\Config\Database as Database;
  use App\Data\Entities\Gruppo as Gruppo;
  use \PDO as PDO;
  require_once __DIR__ . '/../../../resources/config/Database.php';
  require_once __DIR__ . '/../Entities/Gruppo.php';

  class GruppoDao
  {

    private $connection;
    private $S_BY_NOME;
    private $I_UTENTE_GRUPPO;

    public function __construct()
    {
      $Db = new Database();
      $this->connection = $Db->connect();
      $this->S_BY_NOME = "SELECT * FROM gruppo WHERE nome=:nome";
      $this->I_UTENTE_GRUPPO = "INSERT INTO utente_gruppo(id_utente, id_gruppo) VALUES(:id_utente, :id_gruppo)";
    }

    // metodo che genera un oggetto Gruppo a partire dal risultato di una query
    public function generaGruppo($gruppo)
    {
      $Gruppo = new Gruppo();
      $Gruppo->setId( $gruppo['id'] );
      $Gruppo->setNome( $gruppo['nome'] );
      return $Gruppo;
    }

    public function getByNome($nome)
    {
      $stmt = $this->connection->prepare( $this->S_BY_NOME );
      $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
      $stmt->execute();
      $gruppo = $stmt->fetch();
      return $this->generaGruppo($gruppo);
    }

    public function connectUtente($Gruppo, $Utente)
    {
      $stmt = $this->connection->prepare( $this->I_UTENTE_GRUPPO );
      $stmt->bindParam(':id_utente', $Utente->getId(), PDO::PARAM_INT);
      $stmt->bindParam(':id_gruppo', $Gruppo->getId(), PDO::PARAM_INT);
      $stmt->execute();
    }

  }


?>