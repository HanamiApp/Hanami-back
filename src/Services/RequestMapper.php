<?php

  namespace App\Services;

  use \ReflectionClass as ReflectionClass;
  use App\Services\HTTP;
  use App\Services\Routes;
  require_once __DIR__ . '/Routes.php';
  require_once __DIR__ . '/HTTP.php';


  class RequestMapper
  {

    private static $routes = Routes::ROUTES;

    public static function mapRequest($method, $uri)
    {
      // rimpiazzo tutti i numeri con '{id}' per matchare la uri
      $replacedUri = preg_replace('/(\d+)/', '{id}', $uri);
      // controllo che la rotta esista
      if ( !isset(RequestMapper::$routes[$replacedUri]) ) HTTP::sendJsonResponse(404, 'route ' . $replacedUri . ' not found');
      // prendo i numeri dalla rotta
      preg_match_all('/\/(\d+)/', $uri, $parameters);
      // separo il Controller dal metodo da chiamare
      $exploded = explode('@', RequestMapper::$routes[$replacedUri]);
      $controller = $exploded[0];
      $function = $exploded[1];
      // istanzio la classe del controller e chiamo il metodo di riferimento
      $ClassName = 'App\Controllers\\' . $controller;
      $Instance = new $ClassName();
      $Instance->$function($parameters);
    }

  }
  
?>