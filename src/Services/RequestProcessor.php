<?php


  // include of all Controllers
  $controllersDir = __DIR__ . '/../Controllers';
  foreach( glob("${controllersDir}/*") as $file ) {
    include_once($file);
  }

  
  class RequestProcessor
  {
    // request processor function
    public static function process($method, $endpoint, $id)
    {
      $controllerName = ucfirst($endpoint) . "Controller";
      // request heandler
      switch($method) {
        case 'GET':
          $controllerName::index();
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

  }


?>