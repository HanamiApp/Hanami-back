<?php


  namespace App\Controllers\Rest;

  use App\Services\HTTP as HTTP;
  use App\Services\Security\RequestChecker as RequestChecker;
  require_once __DIR__ . '/../../Services/HTTP.php';
  require_once __DIR__ . '/../../Services/Security/RequestChecker.php';

  // TODO: da sostituire con il controller che fara simone
  class TreeprovController
  {
    // method that responde at GET with all users
    public function index()
    {
      HTTP::sendJsonResponse( 200, "Tree index" );
    }
    // method that responde at GET with the user correspond at given id
    public function get( $id = null )
    {
      if ( $id == null ) die( HTTP::sendJsonResponse(400, 'WrongIdProvided') ); 
    }
    // method that responde at POST ( registration method )
    public function create()
    {
      HTTP::sendJsonResponse( 200, "Tree create" );
    }
    // method that responde at PUT
    public function update( $id = null )
    {
      RequestChecker::validateRequest();
      if ( $id == null ) die( HTTP::sendJsonResponse(400, 'WrongIdProvided') ); 
      HTTP::sendJsonResponse( 200, "Tree update, id: ${id}" );
    }
    // method that responde at DELETE
    public function delete( $id = null )
    {
      RequestChecker::validateRequest();
      if ( $id == null ) die( HTTP::sendJsonResponse(400, 'WrongIdProvided') );
      HTTP::sendJsonResponse( 200, "Tree delete, id: ${id}" );
    }
    
  }
  

?>