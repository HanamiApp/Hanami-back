<?php

  namespace App\Controllers;

  use App\Services\HTTP;
  use App\Services\Logger;
  require_once __DIR__ . '/../Services/Logger.php';
  require_once __DIR__ . '/../Services/HTTP.php';

  class PhotoController
  {

    public function getPhoto( $name )
    {
      Logger::add($name);
      $userId = $_SESSION['user_id'];
      $basePath = __DIR__ . "/../Photo/";
      if ( !file_exists($basePath.$name.$userId.".png") ) HTTP::sendJsonResponse( 404, "Photo not found" );
      HTTP::sendImageResponse( 200, file_get_contents(__DIR__ . "/../Photo/${name}${userId}.png") );
    }

  }

?>