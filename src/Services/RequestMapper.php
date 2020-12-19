<?php

  namespace App\Services;

  use App\Services\HTTP;
  use App\Services\Routes;
  require_once __DIR__ . '/Routes.php';
  require_once __DIR__ . '/HTTP.php';


  class RequestMapper
  {

    private static $routes;

    public static function mapRequest($method, $uri)
    {
      // TODO: aggiungere il controllo in caso di metodo not allowed ( e.g. OPTIONS )
      // in base al metodo della chiamata carichiamo il corretto array
      $array = $method . '_ROUTES';
      RequestMapper::$routes = Routes::$$array;
      // genero l'espressione regolare per fare matching con le rotte
      $routeMatcher = RequestMapper::generateRouteMatcher($uri);
      $expoled = [];
      $path = null;
      foreach ( RequestMapper::$routes as $key => $route ) {
        if ( preg_match($routeMatcher, $key) ) {
          $exploded = explode('@', $route);
          $path = $key;
          break;
        }
      }
      // controllo se la rotta e accetata
      if ( !isset($exploded) ) HTTP::sendJsonResponse(404, "route ${uri} not found");
      $controller = $exploded[0];
      $function = $exploded[1];
      // prendo i nomi delle variabili dichiarate nella rotta
      preg_match_all('/:([a-z_]+)/', $path, $vars);
      $vars = $vars[1];
      // prendo i valori della rotta da passare al metodo chiamato
      preg_match_all('/:([0-9a-zA-Z]+)/', $uri, $parameters);
      $parameters = $parameters[1];
      // istanzio la classe del controller e chiamo il metodo di riferimento
      $ClassName = 'App\Controllers\\' . $controller;
      $Instance = new $ClassName();
      $Instance->$function(...$parameters);
    }

    private static function generateRouteMatcher($route)
    {
      // sostituisco ai parametri della $route l'espressione regolare ':[0-9a-zA-Z]+'
      $matcher = preg_replace('/:[0-9a-zA-Z]+/', ':[0-9a-zA-Z_]+', $route);
      $matcher = preg_replace('/\//', '\/', $matcher);
      return "/${matcher}\$/";
    }

  }
  
?>