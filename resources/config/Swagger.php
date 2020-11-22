<?php

  namespace App\Resources\Config;

  require_once "vendor/autoload.php";


  class Swagger
  {

    public static function generateDocumentation()
    {
      // scanning the project folder
      $openapi = \OpenApi\scan(__DIR__ . '/../../src');
      // creating doc file
      $swaggerDoc = fopen(__DIR__ . "/../../swaggerui/swagger.json", "w");
      fwrite($swaggerDoc, $openapi->toJson());
    }

  }

  
  

?>