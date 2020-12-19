<?php

  namespace App\Controllers;

  use App\Services\HTTP as HTTP;
  use App\Services\Security\RequestChecker as RequestChecker;
  use App\Services\Security\TokenManager as TokenManager;
  require_once __DIR__ . '/../Services/Security/TokenManager.php';
  require_once __DIR__ . '/../Services/HTTP.php';
  require_once __DIR__ . '/../Services/Security/RequestChecker.php';


  class UpdateController
  {
    // method that responde at GET with all users
    public function index()
    {
      HTTP::sendJsonResponse( 200, "Update index" );
    }

    // method that responde at GET with the user correspond at given id
    public function get( ...$params )
    {
      $id = $params[0];
      if ( $id == null ) die( HTTP::sendJsonResponse(400, 'WrongIdProvided') ); 
      HTTP::sendJsonResponse( 200, "Update get with id: {$id}" );
    }

    // method that responde at POST ( registration method )
    public function create()
    {
      // validazione dell richiesta dell'utente
      $cookieData = json_decode(str_replace("tokens=", "", urldecode($_SERVER['HTTP_COOKIE'])));
      $token = $cookieData->token;
      $refresh = $cookieData->refresh;
      $User = TokenManager::verifyJWT($token, $refresh);
      if ( !isset($User) ) HTTP::sendJsonResponse( 401, null );
      HTTP::sendJsonResponse( 200, $User->__toArray() );
      // echo urldecode($_SERVER['HTTP_COOKIE']);
      // HTTP::sendJsonResponse(201, json_decode(urldecode($_SERVER['HTTP_COOKIE'])));
      // HTTP::sendJsonResponse( 200, "Update create" );
    }

    // method that responde at PUT
    public function update( ...$params )
    {
      $id = $params[0];
      RequestChecker::validateRequest();
      if ( $id == null ) die( HTTP::sendJsonResponse(400, 'WrongIdProvided') );
      HTTP::sendJsonResponse( 200, "Update update, id: ${id}" );
    }

    // method that responde at DELETE
    public function delete( ...$params )
    {
      $id = $params[0];
      RequestChecker::validateRequest();
      if ( $id == null || gettype($id) != 'integer' ) die( HTTP::sendJsonResponse(400, 'WrongIdProvided') );
      HTTP::sendJsonResponse( 200, "Update delete, id: ${id}" );
    }
    
  }
  

?>