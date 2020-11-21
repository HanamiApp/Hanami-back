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
    private $I_UTENTE, $I_RT;
    private $S_ID_BY_EMAIL, $S_RT_BY_USER_ID;
    private $D_RT_BY_USER_ID;

    public function __construct()
    {
      $Db = new Database();
      $this->connection = $Db->connect();
      $this->I_UTENTE = "INSERT INTO utente(nome, cognome, email, `password`, regione) VALUES(:nome, :cognome, :email, :password, :regione)";
      $this->S_ID_BY_EMAIL = "SELECT * FROM utente WHERE email=:email";
      $this->S_RT_BY_USER_ID = "SELECT token FROM refresh_tokens WHERE id_user=:id_user";
      $this->I_RT = "INSERT INTO refresh_tokens(id_user, token) VALUES(:id_user, :token)";
      $this->D_RT_BY_USER_ID = "DELETE FROM refresh_tokens WHERE id_user=:id_user";    
    }

    public function generateUser($row)
    {
      if ( $row == null ) return null;
      $User = new Utente();
      $User->setId( $row['id']);
      $User->setNome( $row['nome']);
      $User->setCognome( $row['cognome']);
      $User->setEmail( $row['email']);
      $User->setPassword( $row['password']);
      $User->setRegione( $row['regione']);   
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

    // funzione che inserisce l'Utente passato nel DB
    public function store($row)
    {
      if ( $this->isEmailUsed($row->getEmail()) ) die('Error: emailAlreadyUsed');
      $stmt = $this->connection->prepare( $this->I_UTENTE );
      $stmt->bindParam(':nome', $row->getNome(), PDO::PARAM_STR);
      $stmt->bindParam(':cognome', $row->getCognome(), PDO::PARAM_STR);
      $stmt->bindParam(':email', $row->getEmail(), PDO::PARAM_STR);
      $stmt->bindParam(':password', $row->getPassword(), PDO::PARAM_STR);
      $stmt->bindParam(':regione', $row->getRegione(), PDO::PARAM_STR);
      $stmt->execute();
      $row->setId( $this->connection->lastInsertId() );
    }

    // funzione che restituisce un utente data una mail
    public function getUserByEmail($email)
    {
      $stmt = $this->connection->prepare( $this->S_ID_BY_EMAIL );
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->execute();
      $row = $stmt->fetch();
      return $this->generateUser($row);
    }

    // funzione che restituisce il token associato all'utente
    public function getUserRefreshToken( $id_user )
    {
      $stmt = $this->connection->prepare( $this->S_RT_BY_USER_ID );
      $stmt->bindParam(':id_user', $id_user);
      if (!$stmt->execute()) return null;
      $row = $stmt->fetch();
      return $row['token'];
    }

    // funzione che salva il token dell'utente
    public function storeRefreshToken( $id_user, $refreshToken )
    {
      $stmt = $this->connection->prepare( $this->I_RT );
      $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT );
      $stmt->bindParam(':token', $refreshToken, PDO::PARAM_STR );
      $stmt->execute();
    }

    // funzione che cancella il token associato all'utente
    public function deleteRefreshToken( $id_user )
    {
      $stmt = $this->connection->prepare( $this->D_RT_BY_USER_ID );
      $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
      $stmt->execute();
    }


  }


?>