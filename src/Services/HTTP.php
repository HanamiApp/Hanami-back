<?php

  namespace App\Services;

  use App\Services\Logger as Logger;
  require_once __DIR__ . "/Logger.php";
  require_once "vendor/autoload.php";


  class HTTP
  {

    const HTTP_VERSION = '1.1';
    const HTTP_STATUS = [
      // 2xx
      200 => 'OK',
      201 => 'Created',
      202 => 'Accepted',
      204 => 'No Content',
      205 => 'Reset Content',
      // 4xx
      400 => 'Bad Request',
      401 => 'Unauthorized',
      403 => 'Forbidden',
      404 => 'Not Found',
      405 => 'Method Not Allowed',
      408 => 'Request Timeout',
      409 => 'Conflict',
      415 => 'Unsupported Media Type',
      // 5xx
      500 => 'Internal Server Error',
      501 => 'Not Implemented'
    ];

    public static function sendJsonResponse( $code, $data = "", $cookieData = null )
    {
      if( !empty($cookieData) ) HTTP::setCookie( $cookieData );
      header("HTTP/" . HTTP::HTTP_VERSION . " {$code} " . HTTP::HTTP_STATUS[$code]);
      print_r(json_encode(["data" => $data, "logs" => Logger::all()]));
      die();
    }

    public static function sendImageResponse( $code, $content )
    {
      header("content-type: image/png");
      header("HTTP/" . HTTP::HTTP_VERSION . " {$code} " . HTTP::HTTP_STATUS[$code]);
      print_r($content);
    }

    public static function sendResponse( $code, $data = "" )
    {
      header("HTTP/" . HTTP::HTTP_VERSION . " {$code} " . HTTP::HTTP_STATUS[$code]);
      print_r(["data" => $data, "logs" => Logger::all()]);
      die();
    }

    public static function setCookie( $cookieData )
    {
      $cookieOptions = [ 'httponly' => true, 'path' => '/', 'domain' => '', 'SameSite' => 'Lax' ];
      $value = json_encode($cookieData);
      setcookie( "tokens", $value, $cookieOptions);
    }

  }


?>