<?php

  namespace App\Controllers\Rest;

  use App\Data\Entities\Plant;
  use App\Data\Entities\PlantState;
  use App\Data\Entities\GiftState;
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


  class PlantController {
    
    public static function index()
    {
      // getall
    }

    //metodo per la GET
    public static function get( $id )
    {
      $PlantDao = new PlantDao();
      $PlantStateDao = new PlantStateDao();
      $PlantState = $PlantDao->getById($id);
      echo json_encode($PlantState->__toString());
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
      $Plant->hasGift = $POST['hasGift'];
      $Plant->placeId = $POST['placeId'];
      $Plant->plantStateId = $PlantState->id;
      // controllo se la pianta e un regalo
      if ( $Plant->hasGift ) {
        // creo uno stato base per il regalo
        $GiftState = new GiftState();
        $GiftStateDao->store($GiftState);
        $Plant->giftStateId = $GiftState->id;
      }
      // TODO: sostituire la riga seguente con l'id dell'utente correntemente autenticato
      $Plant->userId = $POST['userId'];
      $Plant->speciesId = $POST['speciesId'];
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