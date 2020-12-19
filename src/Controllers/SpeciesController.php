<?php

   namespace App\Controllers;

   use App\Data\DTO\SpeciesDTO;
   use App\Data\Dao\SpeciesDao as SpeciesDao;
   require_once __DIR__ . '/../Data/Dao/SpeciesDao.php';
   require_once __DIR__ . '/../Data/DTO/SpeciesDTO.php';

   class SpeciesController{

      public static function index()
      {
         $SpeciesDao = new SpeciesDao();
         $arraySpecies = array();
         $arraySpecies = $SpeciesDao->getAll();
         $arraySpeciesDTO = array();

         for($i = 0 ; $i < count($arraySpecies) ; $i++)
            array_push( $arraySpeciesDTO , new SpeciesDTO($arraySpecies[$i]) );
          
         echo json_encode($arraySpeciesDTO);
      }

   }

?>