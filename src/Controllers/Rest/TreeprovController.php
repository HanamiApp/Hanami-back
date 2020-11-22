<?php


  namespace App\Controllers\Rest;
  use App\Services\Security\RequestChecker as RequestChecker;
  require_once __DIR__ . '/../../Services/Security/RequestChecker.php';

  // TODO: da sostituire con il controller che fara simone
  class TreeprovController
  {
    // method that responde at GET with all users
    public function index()
    {
      echo "Tree index";
    }
    // method that responde at GET with the user correspond at given id
    public function get( $id = null )
    {
      if ( $id == null ) die('WrongIdProvided'); 
    }
    // method that responde at POST ( registration method )
    public function create()
    {
      echo "Tree create";
    }
    // method that responde at PUT
    public function update( $id = null )
    {
      RequestChecker::validateRequest();
      if ( $id == null ) die('WrongIdProvided'); 
      echo "Tree update, id: ${id}";
    }
    // method that responde at DELETE
    public function delete( $id = null )
    {
      RequestChecker::validateRequest();
      if ( $id == null ) die('WrongIdProvided'); 
      echo "Tree delete, id: ${id}";
    }
    
  }
  

?>