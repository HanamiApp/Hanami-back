<?php

  namespace App\Controllers\Rest;

  use App\Data\Entities\Plant as Plant;
  use App\Data\Entities\PlantState as PlantState;
  use App\Data\Entities\GiftState as GiftState;
  use App\Data\DTO\PlantWithStateDTO as PlantWithStateDTO;
  use App\Data\Dao\PlantDao as PlantDao;
  use App\Data\Dao\PlantStateDao as PlantStateDao;
  use App\Data\Dao\GiftStateDao as GiftStateDao;
  use App\Controllers\QRCodeController as QRCodeController;
  use App\Services\HTTP as HTTP;
  require_once __DIR__ . '/../../Data/Entities/Plant.php';
  require_once __DIR__ . '/../../Data/Entities/PlantState.php';
  require_once __DIR__ . '/../../Data/Entities/GiftState.php';
  require_once __DIR__ . '/../../Data/Dao/PlantDao.php';
  require_once __DIR__ . '/../../Data/Dao/PlantStateDao.php';
  require_once __DIR__ . '/../../Data/Dao/GiftStateDao.php';
  require_once __DIR__ . '/../QRCodeController.php';
  require_once __DIR__ . '/../../Services/HTTP.php';
  require_once __DIR__ . '/../../Data/DTO/PlantWithStateDTO.php';


  class PlantController {
    
    public static function index()
    {
      $PlantDao = new PlantDao();
      $PlantStateDao = new PlantStateDao();

      $arrayPlant = $PlantDao->getAll();
      $arrayPlantState = $PlantStateDao->getAll();
      $arrayPlantsDTO = array();

      for($i = 0 ; $i < count($arrayPlant) ; $i++)
          array_push( $arrayPlantsDTO , new PlantWithStateDTO($arrayPlant[$i], $arrayPlantState[$i]) );
          
      echo json_encode($arrayPlantsDTO);
    }

    //metodo per la GET
    public static function get( $id )
    {
      $PlantDao = new PlantDao();
      $PlantStateDao = new PlantStateDao();
      $Plant = new Plant();
      $PlantState = new PlantState();

      $Plant = $PlantDao->getById($id);
      $PlantState = $PlantStateDao->getById($Plant->plantStateId);

      $PlantWithStateDTO = new PlantWithStateDTO($Plant, $PlantState);

      echo json_encode($PlantWithStateDTO->toString());
    }

    //metodo per la POST
    public static function create()
    {
      $POST = (array)json_decode(file_get_contents('php://input'));
      $PlantDao = new PlantDao();
      $PlantStateDao = new PlantStateDao();
      $GiftStateDao = new GiftStateDao();
      //check campi inseriti dall'utente che crea la pianta

      // creazione dello stato della pianta di default
      $PlantState = new PlantState();
      $PlantStateDao->store($PlantState);
      // plant creation
      $Plant = new Plant();
      $Plant->name = $POST['name'];
      $Plant->hasGift = $POST['has_gift'];
      $Plant->placeId = $POST['id_place'];
      $Plant->plantStateId = $PlantState->id;
      // controllo se la pianta è un regalo
      if ( $Plant->hasGift ){
        // creo uno stato base per il regalo
        $GiftState = new GiftState();
        $GiftStateDao->store($GiftState);
        $Plant->giftStateId = $GiftState->id;
      }
      // TODO: sostituire la riga seguente con l'id dell'utente correntemente autenticato
      $Plant->userId = $POST['id_user'];
      $Plant->speciesId = $POST['id_species'];
      $PlantDao->store($Plant);
      // creazione qrcode
      $Plant->qrCode = QRCodeController::generateQRCodeURL($Plant, 200, 200);
      $PlantDao->updateQRCode($Plant);
      HTTP::sendJsonResponse(201, "Plant created");
    }

    // method that responde at PUT
    public function update( $id = null )
    {
      // dopo
    }
      
    // method that responde at DELETE
    public function delete( $id )
    {
      //
    }
    
  }