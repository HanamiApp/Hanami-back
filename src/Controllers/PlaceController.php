<?php

  namespace App\Controllers;

  use App\Services\HTTP;
  use App\Data\Dao\PlaceDao;
  use App\Data\DTO\PlaceDTO;
  use App\Data\DTO\SearchDTO;
  require_once __DIR__ . '/../Data/DTO/SearchDTO.php';
  require_once __DIR__ . '/../Data/DTO/PlaceDTO.php';
  require_once __DIR__ . '/../Data/Dao/PlaceDao.php';
  require_once __DIR__ . '/../Services/HTTP.php';

  class PlaceController
  {

    private $PlaceDao;

    public function __construct()
    {
      $this->PlaceDao = new PlaceDao();
    }

    public function index()
    {
      $Places = $this->PlaceDao->getAll();
      $PlacesDTO = [];
      foreach( $Places as $Place ) {
        array_push( $PlacesDTO, new PlaceDTO($Place) );
      }
      HTTP::sendJsonResponse( 200, $PlacesDTO );
    }

    public function storeFromJson() {
      $path = __DIR__ . '/../../db/it.json';
      $json = json_decode(file_get_contents($path));
      $array = [];
      foreach( $json as $item ) {
        $temp = [
          "city" => $item->city,
          "latitude" => (float)$item->lat,
          "longitude" => (float)$item->lng,
          "region" => $this->parseRegion($item->admin_name)
        ];
        $this->PlaceDao->store($temp);
      }
      HTTP::sendJsonResponse( 201, $array);
    }

    public function search() {
      $POST = (array)json_decode(file_get_contents('php://input'));
      $SearchDTO = new SearchDTO($POST);
      
      $Places = $this->PlaceDao->getAll();
      $filters = $SearchDTO->getFilters();
      // filtro
      $result = array_filter( $Places, function($Place) use ($filters) {
        $outcome = true;
        foreach( $filters as $key => $value ) {
          if ( gettype($Place->{$key}) === 'string' ) {
            $outcome = $outcome && preg_match('/(?i)'.$value.'/', $Place->{$key});
          } else {
            $outcome = $outcome && $Place->{$key} === $value;
          }
        }
        return $outcome;
      });
      // converto
      $PlacesDTO = array_map( function($Place) {
        return new PlaceDTO($Place);
      }, $result);
      HTTP::sendJsonResponse( 200, $PlacesDTO );
    }

    private function parseRegion( $region ) {
      switch( $region ) {
        case 'Molise':
          return 'MOLISE';
          break;
        case 'Valle d’Aosta':
          return 'VALLE_D_AOSTA';
          break;
        case 'Basilicata':
          return 'BASILICATA';
          break;
        case 'Lazio':
          return 'LAZIO';
          break;
        case 'Lombardy':
          return 'LOMBARDIA';
          break;
        case 'Piedmont':
          return 'PIEMONTE';
          break;
        case 'Campania':
          return 'CAMPANIA';
          break;
        case 'Sicilia':
          return 'SICILIA';
          break;
        case 'Liguria':
          return 'LIGURIA';
          break;
        case 'Emilia-Romagna':
          return 'EMILIA_ROMAGNA';
          break;
        case 'Tuscany':
          return 'TOSCANA';
          break;
        case 'Puglia':
          return 'PUGLIA';
          break;
        case 'Sardegna':
          return 'SARDEGNA';
          break;
        case 'Veneto':
          return 'VENETO';
          break;
        case 'Friuli-Venezia Giulia':
          return 'FRIULI_VENEZIA_GIULIA';
          break;
        case 'Calabria':
          return 'CALABRIA';
          break;
        case 'Umbria':
          return 'UMBRIA';
          break;
        case 'Abruzzo':
          return 'ABRUZZO';
          break;
        case 'Trentino-Alto Adige':
          return 'TRENTINO_ALTO_ADIGE';
          break;
        case 'Marche':
          return 'MARCHE';
          break;
      }
    }

  }

?>