<?php


  namespace App\Data\Dao;
  use App\Resources\Config\Database as Database;
  use App\Data\Entities\Group as Group;
  use \PDO as PDO;
  require_once __DIR__ . '/../../../resources/config/Database.php';
  require_once __DIR__ . '/../Entities/Group.php';

  class GroupDao
  {

    private $connection;
    private $S_BY_NAME;
    private $I_USER_GROUP;

    public function __construct()
    {
      $Db = new Database();
      $this->connection = $Db->connect();
      $this->S_BY_NAME = "SELECT * FROM `group` WHERE `name`=:name";
      $this->I_USER_GROUP = "INSERT INTO `user_group`(`id_user`, `id_group`) VALUES(:id_user, :id_group)";
    }

    // metodo che genera un oggetto Group a partire dal risultato di una query
    public function generateGroup( $row )
    {
      if ( !isset($row) ) return null;
      $Group = new Group();
      $Group->id = (int)$row['id'];
      $Group->name = $row['name'];
      return $Group;
    }

    public function getByName( $name )
    {
      $stmt = $this->connection->prepare( $this->S_BY_NAME );
      $stmt->bindParam(':name', $name, PDO::PARAM_STR);
      $stmt->execute();
      return $this->generateGroup($stmt->fetch());
    }

    public function connectUser( $Group, $User )
    {
      if ( !isset($Group) || !isset($User) ) return;
      $stmt = $this->connection->prepare( $this->I_USER_GROUP );
      $stmt->bindParam(':id_user', $User->id, PDO::PARAM_INT);
      $stmt->bindParam(':id_group', $Group->id, PDO::PARAM_INT);
      $stmt->execute();
    }

  }


?>