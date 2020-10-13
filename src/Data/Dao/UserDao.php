<?php

  namespace App\Data\Dao;
  use App\Resources\Config\Database as Database;
  use \PDO as PDO;
  require_once __DIR__ . '/../../../resources/config/Database.php';

  class UserDao
  {

    private $connection;
    private $I_USER;

    public function __construct()
    {
      $db = new Database();
      $this->connection = $db->connect();
      $this->I_USER = "INSERT INTO utente(nome, cognome, email, `password`, regione) values(:nome, :cognome, :email, :password, :regione)";
    }

    public function store($User)
    {
      $stmt = $this->connection->prepare($this->I_USER);
      $stmt->bindParam(':nome', $User->getNome(), PDO::PARAM_STR);
      $stmt->bindParam(':cognome', $User->getCognome(), PDO::PARAM_STR);
      $stmt->bindParam(':email', $User->getEmail(), PDO::PARAM_STR);
      $stmt->bindParam(':password', $User->getPassword(), PDO::PARAM_STR);
      $stmt->bindParam(':regione', $User->getRegione(), PDO::PARAM_STR);
      $stmt->execute();
    }

  }


?>