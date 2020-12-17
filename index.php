<?php

   namespace App;
   
   use App\Resources\Config\EnvLoader;
   use App\Services\RequestProcessor;
   use App\Services\RequestMapper;
   require_once __DIR__ . '/src/Services/RequestMapper.php';
   require_once __DIR__ . '/src/Services/RequestProcessor.php';
   // include the EnvLoader module and load all local variables
   require_once __DIR__ . '/resources/config/EnvLoader.php';

   header("Access-Control-Allow-Headers: origin, x-requested-with, content-type");
   header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
   header("Access-Control-Allow-Origin: http://localhost:8080");
   header("Access-Control-Allow-Credentials: true");
   header("Content-Type: application/json");

   EnvLoader::load();

   $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
   $explodedUri = explode('/', $uri);
   $method = $_SERVER['REQUEST_METHOD'];
   if( $method === 'OPTIONS' ) return 0;
   $baseRoute = $explodedUri[1];

   RequestMapper::mapRequest($method, $uri);
   
?>