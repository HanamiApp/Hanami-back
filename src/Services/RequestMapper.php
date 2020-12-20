<?php

  namespace App\Services;

  use App\Controllers\AuthenticationController;
  use App\Services\HTTP;
  use App\Services\Routes;
  require_once __DIR__ . '/Routes.php';
  require_once __DIR__ . '/HTTP.php';


  class RequestMapper
  {

    private static $routes;

    public static function mapRequest( $method, $uri )
    {
      // TODO: aggiungere il controllo in caso di metodo not allowed ( e.g. OPTIONS )
      // in base al metodo della chiamata carichiamo il corretto array
      $array = $method . '_ROUTES';
      RequestMapper::$routes = Routes::$$array;
      // genero l'espressione regolare per fare matching con le rotte
      $routeMatcher = RequestMapper::generateRouteMatcher($uri);
      $unexplodedRoute = [];
      $path = null;
      foreach ( RequestMapper::$routes as $key => $route ) {
        if ( preg_match($routeMatcher, $key) ) {
          $unexplodedRoute = $route;
          $path = $key;
          break;
        }
      }
      // controllo se la rotta e accetata
      if ( empty($unexplodedRoute) ) HTTP::sendJsonResponse(404, "route ${uri} not found");
      // separo le varie parti della rotta
      $exploded = RequestMapper::explodeRoute($unexplodedRoute);
      $controller = $exploded[0];
      $function = $exploded[1];
      $permissions = RequestMapper::generatePermissions($exploded[2]);
      Logger::add($permissions);
      // constrollo i permessi dell'utente corrente
      AuthenticationController::validateRequest($permissions);
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

    private static function generateRouteMatcher( $route )
    {
      // sostituisco ai parametri della $route l'espressione regolare ':[0-9a-zA-Z]+'
      $matcher = preg_replace('/:[0-9a-zA-Z]+/', ':[0-9a-zA-Z_]+', $route);
      $matcher = preg_replace('/\//', '\/', $matcher);
      return "/${matcher}\$/";
    }

    private static function explodeRoute( $route )
    {
      $exploded = [];
      // prendo il primo pezzo ( Controller )
      $one = explode('@', $route);
      array_push($exploded, $one[0]);

      $two = explode(':', $one[1]);
      // aggiungo la seconda parte ( metodo )
      array_push($exploded, $two[0]);
      // aggiungo la terza parte ( permessi ) se esiste
      if ( count($two) === 2 ) {
        array_push($exploded, $two[1]);
      }
      return $exploded;
    }

    private static function generatePermissions( $string )
    {
      if ( empty($string) ) return [];
      // formato ricevuto = '[p1, p2, p3, ...]'
      $permissions = [];
      $exploded = explode(',', $string);
      $exploded = preg_replace('/(\[|\])/', '', $exploded);
      $permissions = preg_replace('/\s+/', '', $exploded);
      return $permissions;
    }

  }
  
?>