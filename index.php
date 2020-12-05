<?php

   namespace App;
   
   use App\Resources\Config\EnvLoader;
   use App\Services\RequestProcessor;
   require_once __DIR__ . '/src/Services/RequestProcessor.php';
   // include the EnvLoader module and load all local variables
   require_once __DIR__ . '/resources/config/EnvLoader.php';

   header("Access-Control-Allow-Headers: origin, x-requested-with, content-type");
   header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
   header("Access-Control-Allow-Origin:*");
   header("Content-Type: application/json");

   EnvLoader::load();

   $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
   $explodedUri = explode('/', $uri);
   $method = $_SERVER['REQUEST_METHOD'];
   $baseRoute = $explodedUri[1];
   // dobbiamo differenziare le chiamate REST da quelle non
   // localhost:8080/... ( no REST )
   // localhost:8080/api/... ( REST )
   if ( $baseRoute !== 'api' ) {
      // no REST call
      $endpoint = $explodedUri[1];
      $id = $explodedUri[2];
      // TODO: cambiare il nome da ProvBaseProcess a BaseProcess quando @noemi lo avra implementato
      RequestProcessor::BaseProcess($method, $endpoint, $id);
   } else {
      $endpoint = $explodedUri[2];
      // REST call
      $id = $explodedUri[3];
      RequestProcessor::RestProcess($method, $endpoint, $id);
   }
   
   
?>