<?php

  namespace App\Data\Dao;
  use App\Resources\Config\Database as Database;
  use App\Data\Entities\Utente as User;
  use \PDO as PDO;
  require_once __DIR__ . '/../../../resources/config/Database.php';

  class UtenteDao
  {

    private $connection;
    private $I_UTENTE;
    private $S_USER_BY_ID;
    private $S_ID_BY_EMAIL;

    public function __construct()
    {
      $Db = new Database();
      $this->connection = $Db->connect();
      $this->I_UTENTE = "INSERT INTO utente(nome, cognome, email, `password`, regione) VALUES(:nome, :cognome, :email, :password, :regione)";
      $this->S_USER_BY_ID = "SELECT * FROM utente WHERE id=:id";
      $this->S_ID_BY_EMAIL = "SELECT id FROM utente WHERE email=:email";
    }

    private function generateUser($row)
    {
      if ( empty($row) ) return null;
      $User = new User();
      $User->setId($row['id']);
      $User->setNome($row['nome']);
      $User->setCognome($row['cognome']);
      $User->setEmail($row['email']);
      $User->setPassword($row['password']);
      $User->setRegione($row['regione']);
      return $User;
    }

    // TODO: usare metodo @noemisurr quando sara pronto
    // funczione che controlla se esiste gia un utente con la 'mail' data
    public function isEmailUsed($email)
    {
      $stmt = $this->connection->prepare( $this->S_ID_BY_EMAIL );
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->execute();
      $id = $stmt->fetch();
      if ( $id == null ) return false;
      return true;
    }

    // funzione che restituisce l'utente con l'id dato
    public function getById($id)
    {
      if ( empty($id) ) return null;
      $stmt = $this->connection->prepare( $this->S_USER_BY_ID );
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      return $this->generateUser($stmt->fetch());
    }

    // funzione che inserisce l'Utente passato nel DB
    public function store($Utente)
    {
      if ( $this->isEmailUsed($Utente->getEmail()) ) die('Error: emailAlreadyUsed');
      $stmt = $this->connection->prepare( $this->I_UTENTE );
      $stmt->bindParam(':nome', $Utente->getNome(), PDO::PARAM_STR);
      $stmt->bindParam(':cognome', $Utente->getCognome(), PDO::PARAM_STR);
      $stmt->bindParam(':email', $Utente->getEmail(), PDO::PARAM_STR);
      $stmt->bindParam(':password', $Utente->getPassword(), PDO::PARAM_STR);
      $stmt->bindParam(':regione', $Utente->getRegione(), PDO::PARAM_STR);
      $stmt->execute();
      $Utente->setId( $this->connection->lastInsertId() );
    }

  }


?>