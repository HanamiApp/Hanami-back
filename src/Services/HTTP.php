<?php

  namespace App\Services;

  require_once "vendor/autoload.php";


  class HTTP
  {

    const HTTP_VERSION = '1.1';
    const HTTP_STATUS = [
      200 => 'OK',
      201 => 'Created',
      202 => 'Accepted',
      204 => 'No Content',
      205 => 'Reset Content',
      400 => 'Bad Request',
      401 => 'Unauthorized',
      403 => 'Forbidden',
      404 => 'Not Found',
      405 => 'Method Not Allowed',
      408 => 'Request Timeout',
      409 => 'Conflict',
      415 => 'Unsupported Media Type',
      500 => 'Internal Server Error',
      501 => 'Not Implemented'
    ];

    public static function sendJsonResponse( $code, $data, $cookieData = null )
    {
      if( $cookieData != null ) HTTP::setCookie( $cookieData );
      header("HTTP/" . HTTP::HTTP_VERSION . " {$code} " . HTTP::HTTP_STATUS[$code]);
      echo json_encode($data);
    }

    public static function setCookie( $cookieData )
    {
      $cookieOptions = [ 'httponly' => true, 'path' => '/', 'domain' => '' ];
      $value = json_encode($cookieData);
      setcookie( "tokens", $value, $cookieOptions);
    }

  }


?>