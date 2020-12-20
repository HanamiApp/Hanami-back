<?php

   namespace App\Controllers;

   use App\Data\DTO\SpeciesDTO;
   use App\Data\Dao\SpeciesDao as SpeciesDao;
   use App\Services\HTTP;
   use App\Data\DTO\SearchDTO;
   use App\Services\Logger;
   require_once __DIR__ . '/../Services/Logger.php';
   require_once __DIR__ . '/../Data/DTO/SearchDTO.php';
   require_once __DIR__ . '/../Services/HTTP.php';
   require_once __DIR__ . '/../Data/Dao/SpeciesDao.php';
   require_once __DIR__ . '/../Data/DTO/SpeciesDTO.php';

   class SpeciesController{

      private $SpeciesDao;

      public function __construct()
      {
         $this->SpeciesDao = new SpeciesDao();
      }

      public function index()
      {
         $arraySpecies = array();
         $arraySpecies = $this->SpeciesDao->getAll();

         $arraySpeciesDTO = array();

         for($i = 0 ; $i < count($arraySpecies) ; $i++)
            array_push( $arraySpeciesDTO , new SpeciesDTO($arraySpecies[$i]) );
          
         HTTP::sendJsonResponse( 200, $arraySpeciesDTO );
      }

      public function search()
      {
         $POST = (array)json_decode(file_get_contents('php://input'));
         $SearchDTO = new SearchDTO($POST);
         // prendo le specie dal DB
         $Species = $this->SpeciesDao->getAll();
         $filters = $SearchDTO->getFilters();
         // filtro
         $result = array_filter( $Species, function($Specie) use ($filters) {
            $outcome = true;
            foreach( $filters as $key => $value ) {
               if ( gettype($Specie->{$key}) === 'string' ) {
                  $outcome = $outcome && preg_match('/'.$value.'/', $Specie->{$key});
               } else {
                  $outcome = $outcome && $Specie->{$key} === $value;
               }
            }
            return $outcome;
         });
         // converto
         $SpeciesFiltered = [];
         foreach( $result as $Specie ) {
            array_push($SpeciesFiltered, new SpeciesDTO($Specie));
         }
         // response
         HTTP::sendJsonResponse( 200, $SpeciesFiltered );
      }

   }

?>