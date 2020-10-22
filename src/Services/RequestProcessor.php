<?php

  namespace App\Services;
  // include of all Controllers
  $controllersDir = __DIR__ . '/../Controllers';
  foreach( glob("${controllersDir}/*") as $file ) {
    include_once($file);
  }

  
  class RequestProcessor
  {
    // request processor function
    public static function RestProcess($method, $endpoint, $id = null)
    {
      $controllerName = '\App\Controllers\\' . ucfirst($endpoint) . "Controller";
      // request heandler
      switch($method) {
        case 'GET':
          if ( $id == null )
            $controllerName::index();
          else
            $controllerName::get($id);
        break;
        case 'POST':
          $controllerName::create();
        break;
        case 'PUT':
          $controllerName::update($id);
        break;
        case 'DELETE':
          $controllerName::delete($id);
        break;
        default:
          echo "method HTTP not accepted";
      }
    }

    public static function BaseProcess($method, $endpoint)
    {
      $controllerName = '\App\Controllers\\' . ucfirst($endpoint) . "Controller";

      // Assumo che tutte le richieste siano POST
      $controllerName::authenticate();
    }

  }


?>