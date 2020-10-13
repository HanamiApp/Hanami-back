<?php


  namespace App\Controllers;
  use App\Services\Security\RequestChecker as RequestChecker;
  
  require_once __DIR__ . '/../Services/Security/RequestChecker.php';

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
    // method that responde at POST
    public function create()
    {
      RequestChecker::validateRequest();
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