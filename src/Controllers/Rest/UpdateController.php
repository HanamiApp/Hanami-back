<?php


  namespace App\Controllers\Rest;

  use App\Services\HTTP as HTTP;
  use App\Services\Security\RequestChecker as RequestChecker;
  require_once __DIR__ . '/../../Services/HTTP.php';
  require_once __DIR__ . '/../../Services/Security/RequestChecker.php';


  class UpdateController
  {
    // method that responde at GET with all users
    public function index()
    {
      HTTP::sendJsonResponse( 200, "Update index" );
    }
    // method that responde at GET with the user correspond at given id
    public function get( $id = null )
    {
      if ( $id == null ) die( HTTP::sendJsonResponse(400, 'WrongIdProvided') ); 
      HTTP::sendJsonResponse( 200, "Update get with id: {$id}" );
    }
    // method that responde at POST ( registration method )
    public function create()
    {
      // TODO: password hashing
      // TODO: informarsi se il token deve essere messo nel DB
      HTTP::sendJsonResponse( 200, "Update create" );
    }
    // method that responde at PUT
    public function update( $id = null )
    {
      RequestChecker::validateRequest();
      if ( $id == null ) die( HTTP::sendJsonResponse(400, 'WrongIdProvided') );
      HTTP::sendJsonResponse( 200, "Update update, id: ${id}" );
    }
    // method that responde at DELETE
    public function delete( $id = null )
    {
      RequestChecker::validateRequest();
      if ( $id == null || gettype($id) != 'integer' ) die( HTTP::sendJsonResponse(400, 'WrongIdProvided') );
      HTTP::sendJsonResponse( 200, "Update delete, id: ${id}" );
    }
    
  }
  

?>