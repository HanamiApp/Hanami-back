<?php


  namespace App\Controllers;
  use App\Services\Security\RequestChecker as RequestChecker;
  use App\Data\Entities\User;
  use App\Data\Dao\UserDao as UserDao;
  
  require_once __DIR__ . '/../Services/Security/RequestChecker.php';
  require_once __DIR__ . '/../Data/Entities/User.php';
  require_once __DIR__ . '/../Data/Dao/UserDao.php';

  class UserController
  {
    // method that responde at GET with all users
    public function index()
    {
      echo "User index";
    }
    // method that responde at GET with the user correspond at given id
    public function get($id = null)
    {
      echo "User get";
    }
    // method that responde at POST ( registration method )
    public function create()
    {
      RequestChecker::validateRequest();
      $UserDao = new UserDao();
      $post_json = json_decode(file_get_contents('php://input'));
      $POST = (array)$post_json;
      // user creation
      $Utente = new User($POST['nome'], $POST['cognome'], $POST['email'], $POST['password'], $POST['regione']);
      $UserDao->store($Utente);
      echo "User create";
    }
    // method that responde at PUT
    public function update($id = null)
    {
      RequestChecker::validateRequest();
      if ( $id == null || gettype($id) != 'integer' ) die('WrongIdProvided'); 
      echo "User update, id: ${id}";
    }
    // method that responde at DELETE
    public function delete($id = null)
    {
      RequestChecker::validateRequest();
      if ( $id == null || gettype($id) != 'integer' ) die('WrongIdProvided'); 
      echo "User delete, id: ${id}";
    }
    
  }
  

?>