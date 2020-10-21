<?php

  namespace App\Data\Dao;
  use App\Resources\Config\Database as Database;
  use \PDO as PDO;
  use App\Data\Entities\Utente;
  require_once __DIR__ . '/../../../resources/config/Database.php';
  require_once __DIR__ . '/../Entities/Utente.php';

  class UtenteDao
  {

    private $connection;
    private $I_UTENTE;
    private $S_ID_BY_EMAIL;

    public function __construct()
    {
      $Db = new Database();
      $this->connection = $Db->connect();
      $this->I_UTENTE = "INSERT INTO utente(nome, cognome, email, `password`, regione) VALUES(:nome, :cognome, :email, :password, :regione)";
      $this->S_ID_BY_EMAIL = "SELECT * FROM utente WHERE email=:email";
    }

    public function generateUser($user)
    {
      if ( $user == null ) return null;
      $User = new Utente();
      $User->setId( $user['id']);
      $User->setNome( $user['nome']);
      $User->setCognome( $user['cognome']);
      $User->setEmail( $user['email']);
      $User->setPassword( $user['password']);
      $User->setRegione( $user['regione']);   
      return $User;
    }

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

    //funzione che restituisce un utente data una mail
    public function getUserByEmail($email)
    {
      $stmt = $this->connection->prepare( $this->S_ID_BY_EMAIL );
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->execute();
      $user = $stmt->fetch();
      return $this->generateUser($user);
    }

  }


?>