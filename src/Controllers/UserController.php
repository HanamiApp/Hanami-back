<?php


  namespace App\Controllers;

  use App\Controllers\Api\AvatarController;
  use App\Services\Security\TokenManager as TokenManager;
  use App\Data\Entities\User;
  use App\Data\Enums\GroupEnum as GroupEnum;
  use App\Data\Dao\UserDao as UserDao;
  use App\Data\Dao\GroupDao as GroupDao;
  use App\Services\HTTP as HTTP;
  use App\Data\DTO\UserDTO;
  use App\Services\Logger;
  require_once __DIR__ . '/Api/AvatarController.php';
  require_once __DIR__ . '/../Services/Logger.php';
  require_once __DIR__ . '/../Data/DTO/UserDTO.php';
  require_once __DIR__ . '/../Services/Security/RequestChecker.php';
  require_once __DIR__ . '/../Services/Security/TokenManager.php';
  require_once __DIR__ . '/../Data/Entities/User.php';
  require_once __DIR__ . '/../Data/Enums/GroupEnum.php';
  require_once __DIR__ . '/../Data/Dao/UserDao.php';
  require_once __DIR__ . '/../Data/Dao/GroupDao.php';
  require_once __DIR__ . '/../Services/HTTP.php';


  class UserController
  {

    private $UserDao;
    private $GroupDao;

    public function __construct()
    {
      $this->UserDao = new UserDao();
      $this->GroupDao = new GroupDao();
    }


    public function me()
    {
      HTTP::sendJsonResponse( 200, "User me" );
    }

    // method that responde at GET
    public function index()
    {
      $Users = [];
      foreach ( $this->UserDao->getAll() as $user ) {
        array_push( $Users, new UserDTO($user) );
      }
      HTTP::sendJsonResponse( 200, $Users );
    }

    // method that responde at GET/{id}
    public function get( $id )
    {
      if ( !isset($id) ) HTTP::sendJsonResponse(400, 'WrongIdProvided');
      $User = $this->UserDao->getById($id);
      if ( !isset($User) ) HTTP::sendJsonResponse(404, "User with id ${id} not found");
      // response
      HTTP::sendJsonResponse(200, new UserDTO($User));
    }

    // method that responde at POST ( registration method )
    public function create()
    {
      // TODO: ordinare questo controller
      // TODO: password hashing (bcrypt ?)
      // $POST = (array)json_decode(file_get_contents('php://input'));
      // user creation
      $_POST = (array)json_decode($_POST['user']);
      $UserDTO = new UserDTO($_POST);
      $UserEntity = $UserDTO->toEntity();
      $group = empty($_POST['group']) ? GroupEnum::GUEST : GroupEnum::getValueOf($_POST['group']);
      // constrollo se l'utente gia esiste
      $DBUser = $this->UserDao->getByEmail($UserEntity->email);
      if ( isset($DBUser) ) HTTP::sendJsonResponse( 409, "Email already used" );
      // altrimenti inserisco l'utente
      $UserEntity->pathPhoto = '/photo/:profile';
      $isCreated = $this->UserDao->store($UserEntity);
      if ( !$isCreated ) HTTP::sendJsonResponse( 500, "User not created" );
      // setto il gruppo corrispondente
      $Group = $this->GroupDao->getByName($group);
      $this->GroupDao->connectUser($Group, $UserEntity);
      // tokens generation
      $userId = $UserEntity->id;
      $token = TokenManager::generateJWT( $userId );
      $refreshToken = TokenManager::generateRefreshJWT( $userId );
      // File ( Photo )
      $fileDir = __DIR__ . "/../Photo/profile${userId}";
      if ( !empty($_FILES['photo']) ) {
        // caso il cui la foto e presente
        preg_match('/\.([a-zA-Z]+)/', $_FILES['photo']['name'], $fileType);
        $extension = '.' . $fileType[1];
        Logger::add($_FILES['photo']);
        $outcome = move_uploaded_file($_FILES['photo']['tmp_name'], $fileDir . $extension);
        // file error case
        if (!$outcome) HTTP::sendJsonResponse(500, "Errore nel caricamento della foto");
      } else {
        // caso in cui la foto non e presente
        $extension = '.png';
        $avatar = AvatarController::getRandomPNGAvatar();
        // $outcome = move_uploaded_file($avatar, __DIR__ . 'ciao.png');
        $outcome = file_put_contents($fileDir . $extension, $avatar);
        // file error case
        if (!$outcome) HTTP::sendJsonResponse(500, "Errore nel caricamento della foto");
      }
      // response
      HTTP::sendJsonResponse(201, ["userId" => $UserEntity->id], ["token" => $token, "refreshToken" => $refreshToken] );
    }
    
    // method that responde at PUT
    public function update( $id )
    {
      $POST = (array)json_decode(file_get_contents('php://input'));
      if ( !isset($id) ) HTTP::sendJsonResponse(400, 'WrongIdProvided');
      // controllo se ce l'utente con l'id dato
      $DBUser = $this->UserDao->getById($id);
      if ( empty($DBUser) ) HTTP::sendJsonResponse(404, "User with id ${id} not found");
      $PostDTO = new UserDTO($POST);
      $UpdatedUser = $PostDTO->toFilledEntity($DBUser);
      $outcome = $this->UserDao->update($UpdatedUser);
      // response
      if ( $outcome === false ) HTTP::sendJsonResponse( 500 );
      HTTP::sendJsonResponse( 200, "User with id: ${id} updated" );
    }

    // method that responde at DELETE
    public function delete( $id )
    {
      if ( !isset($id) ) HTTP::sendJsonResponse(400, 'WrongIdProvided'); 
      $outcome = $this->UserDao->delete($id);
      // response
      if ( $outcome === false ) HTTP::sendJsonResponse( 500 );
      HTTP::sendJsonResponse( 205, "User with id: ${id} deleted" );
    }
    
  }
  

?>