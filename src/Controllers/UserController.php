<?php


  namespace App\Controllers;

  use App\Services\Security\RequestChecker as RequestChecker;
  use App\Services\Security\TokenManager as TokenManager;
  use App\Data\Entities\User;
  use App\Data\Enums\GroupEnum as GroupEnum;
  use App\Data\Dao\UserDao as UserDao;
  use App\Data\Dao\GroupDao as GroupDao;
  use App\Services\HTTP as HTTP;
  require_once __DIR__ . '/../Services/Security/RequestChecker.php';
  require_once __DIR__ . '/../Services/Security/TokenManager.php';
  require_once __DIR__ . '/../Data/Entities/User.php';
  require_once __DIR__ . '/../Data/Enums/GroupEnum.php';
  require_once __DIR__ . '/../Data/Dao/UserDao.php';
  require_once __DIR__ . '/../Data/Dao/GroupDao.php';
  require_once __DIR__ . '/../Services/HTTP.php';


  class UserController
  {

    public function me()
    {
      HTTP::sendJsonResponse( 200, "User me" );
    }

    // method that responde at GET
    public function index()
    {
      HTTP::sendJsonResponse( 200, "User index" );
    }

    // method that responde at GET/{id}
    public function get( $id )
    {
      if ( $id == null ) die( HTTP::sendJsonResponse(400, 'WrongIdProvided') ); 
      HTTP::sendJsonResponse( 200, "User get with ${id}" );
    }

    // method that responde at POST ( registration method )
    public function create()
    {
      // TODO: password hashing (bcrypt ?)
      RequestChecker::validateRequest();
      $UserDao = new UserDao();
      $GroupDao = new GroupDao();
      $POST = (array)json_decode(file_get_contents('php://input'));
      // user creation
      $User = new User($POST['firstName'], $POST['lastName'], $POST['email'], $POST['password'], $POST['region']);
      $group = empty($POST['group']) ? GroupEnum::GUEST : GroupEnum::getValueOf($POST['group']);
      $isCreated = $UserDao->store($User);
      if ( !$isCreated ) die( HTTP::sendJsonResponse(409, "Email already used") );
      $Group = $GroupDao->getByName($group);
      $GroupDao->connectUser($Group, $User);
      // tokens generation
      $token = TokenManager::generateJWT( $User->id );
      $refreshToken = TokenManager::generateRefreshJWT( $User->id );
      HTTP::sendJsonResponse(201, ["userId" => $User->id], ["token" => $token, "refreshToken" => $refreshToken] );
    }
    
    // method that responde at PUT
    public function update( $id )
    {
      RequestChecker::validateRequest();
      if ( $id == null ) die( HTTP::sendJsonResponse(400, 'WrongIdProvided') );
      HTTP::sendJsonResponse( 200, "User update, id: ${id}" );
    }
    // method that responde at DELETE
    public function delete( $id )
    {
      RequestChecker::validateRequest();
      if ( $id == null || gettype($id) != 'integer' ) die( HTTP::sendJsonResponse(400, 'WrongIdProvided') ); 
      HTTP::sendJsonResponse( 200, "User delete, id: ${id}" );
    }
    
  }
  

?>