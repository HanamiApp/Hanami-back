<?php

  namespace App\Data\Dao;
  use App\Resources\Config\Database as Database;
  use App\Data\Entities\User as User;
  use \PDO as PDO;
  use App\Services\HTTP as HTTP;
  use App\Services\Logger;
  require_once __DIR__ . '/../../Services/Logger.php';
  require_once __DIR__ . '/../../Services/HTTP.php';
  require_once __DIR__ . '/../../../resources/config/Database.php';
  require_once __DIR__ . '/../Entities/User.php';


  class UserDao
  {

    private $connection;
    private $I_USER, $I_RT; // RT = refresh_token
    private $S_ALL, $S_BY_EMAIL, $S_RT_BY_USER_ID, $S_USER_BY_ID;
    private $U_BY_ID;
    private $D_BY_ID;
    private $D_RT_BY_USER_ID;

    public function __construct()
    {
      $Db = new Database();
      $this->connection = $Db->connect();
      // queries
      $this->S_ALL = "SELECT * FROM `user`";
      $this->S_USER_BY_ID = "SELECT * FROM `user` WHERE `id`=:id"; 
      $this->I_USER = "INSERT INTO `user`(`first_name`, `last_name`, `username`, `email`, `password`, `region`, `path_photo`) VALUES(:first_name, :last_name, :username, :email, :password, :region, :pathPhoto)";
      $this->S_BY_EMAIL = "SELECT * FROM `user` WHERE `email`=:email";
      $this->S_RT_BY_USER_ID = "SELECT `token` FROM `refresh_token` WHERE `id_user`=:id_user";
      $this->I_RT = "INSERT INTO `refresh_token`(`id_user`, `token`) VALUES(:id_user, :token)";
      $this->D_RT_BY_USER_ID = "DELETE FROM `refresh_token` WHERE `id_user`=:id_user";
      $this->D_BY_ID = "DELETE FROM `user` WHERE `id`=:id";
      $this->U_BY_ID = "UPDATE `user` SET `first_name`=:first_name, `last_name`=:last_name, `username`=:username, `email`=:email, `password`=:password, `region`=:region, `path_photo`=:path_photo WHERE `id`=:id";
    }

    private function generateUser( $row )
    {
      if ( empty($row) ) return null;
      $User = new User();
      $User->id = (int)$row['id'];
      $User->firstName = $row['first_name'];
      $User->lastName = $row['last_name'];
      $User->username = $row['username'];
      $User->email = $row['email'];
      $User->password = $row['password'];
      $User->region = $row['region'];
      $User->pathPhoto = $row['path_photo'];
      return $User;
    }

    // funzione che restituisce l'utente con l'id dato
    public function getById( $id )
    {
      $stmt = $this->connection->prepare( $this->S_USER_BY_ID );
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      return $this->generateUser($stmt->fetch());
    }

    public function getAll()
    {
      $results = [];
      $stmt = $this->connection->prepare( $this->S_ALL );
      $stmt->execute();
      while( $row = $stmt->fetch() ) {
        array_push( $results, $this->generateUser($row) );
      }
      return $results;
    }

    // funzione che inserisce l'Utente passato nel DB
    public function store( $User )
    {
      // TODO: aggiungere gestione degli errori decente
      $stmt = $this->connection->prepare( $this->I_USER );
      $stmt->bindValue(':first_name', $User->firstName, PDO::PARAM_STR);
      $stmt->bindValue(':last_name', $User->lastName, PDO::PARAM_STR);
      $stmt->bindValue(':username', $User->username, PDO::PARAM_STR);
      $stmt->bindValue(':email', $User->email, PDO::PARAM_STR);
      $stmt->bindValue(':password', $User->password, PDO::PARAM_STR);
      $stmt->bindValue(':region', $User->region, PDO::PARAM_STR);
      $stmt->bindValue(':pathPhoto', $User->pathPhoto, PDO::PARAM_STR);
      $stmt->execute();
      $User->id = $this->connection->lastInsertId();
      return true;
    }

    // funzione che restituisce un utente data una mail
    public function getByEmail( $email )
    {
      $stmt = $this->connection->prepare( $this->S_BY_EMAIL );
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->execute();
      return $this->generateUser($stmt->fetch());
    }

    public function update( $User )
    {
      $stmt = $this->connection->prepare( $this->U_BY_ID );
      $stmt->bindParam(':id', $User->id, PDO::PARAM_INT);
      $stmt->bindParam(':first_name', $User->firstName, PDO::PARAM_STR);
      $stmt->bindParam(':last_name', $User->lastName, PDO::PARAM_STR);
      $stmt->bindParam(':username', $User->username, PDO::PARAM_STR);
      $stmt->bindParam(':email', $User->email, PDO::PARAM_STR);
      $stmt->bindParam(':password', $User->password, PDO::PARAM_STR);
      $stmt->bindParam(':region', $User->region, PDO::PARAM_STR);
      $stmt->bindParam(':path_photo', $User->pathPhoto, PDO::PARAM_STR);
      $outcome = $stmt->execute();
      return $outcome;
    }

    public function delete( $id )
    {
      $stmt = $this->connection->prepare( $this->D_BY_ID );
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $outcome = $stmt->execute();
      return $outcome;
    }


    // funzione che restituisce il token associato all'utente
    public function getRefreshToken( $id_user )
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