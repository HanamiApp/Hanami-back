<?php


   namespace App;
   use App\Resources\Config\EnvLoader;
   use App\Services\RequestProcessor;
   
   require_once __DIR__ . '/src/Services/RequestProcessor.php';
   // include the EnvLoader module and load all local variables
   require_once __DIR__ . '/resources/config/EnvLoader.php';
   EnvLoader::load();
   
   header("Access-Controll-Allow-Origin: *");
   header("Content-Type: application/json; charset=UTF-8");
   header("Access-Controll-Allow-Methods: GET, POST, PUT, DELETE");
   header("Content-Type: application/json; charset=UTF-8");
   header("Access-Controll-Max-Age: 3600");
   
   $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
   $explodedUri = explode('/', $uri);
   $endpoint = $explodedUri[1];
   $id = intval($explodedUri[2]);

   // dobbiamo differenziare le chiamate REST da quelle non
   // localhost:8080/... ( no REST )
   // localhost:8080/api/... ( REST )
   if ( !$endpoint === 'api' ) {
      // no REST call
      RequestProcessor::BaseProcess($_SERVER['REQUEST_METHOD'], $endpoint = $explodedUri[1]);
   } else {
      // REST call
      RequestProcessor::RestProcess($_SERVER['REQUEST_METHOD'], $endpoint = $explodedUri[2], $id = $explodedUri[3]);
   }
   
   
?>