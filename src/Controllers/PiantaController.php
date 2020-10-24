<?php

  namespace App\Controllers;
  use App\Data\Entities\Pianta;
  use App\Data\Entities\StatoPianta;
  use App\Data\Dao\PiantaDao as PiantaDao;
  use App\Data\Dao\StatoPiantaDao as StatoPiantaDao;
  use App\Controllers\QRCodeController as QRCodeController;
  require_once __DIR__ . '/../Data/Entities/Pianta.php';
  require_once __DIR__ . '/../Data/Dao/PiantaDao.php';
  require_once __DIR__ . '/../Data/Entities/StatoPianta.php';
  require_once __DIR__ . '/../Data/Dao/StatoPiantaDao.php';
  require_once __DIR__ . '/QRCodeController.php';

  class PiantaController{

  //metodo per la get
  public static function get($id)
  {
    $PiantaDao = new PiantaDao();
    $StatoPiantaDao = new StatoPiantaDao();

    $Pianta = $PiantaDao->getPianta($id);
    //echo json_encode($Pianta);
  }

  //metodo per la PUT
  public static function create()
  {
      
    $post_json = json_decode(file_get_contents('php://input'));
    $PiantaDao = new PiantaDao();
    // plant creation
    $Pianta = new Pianta($post_json->{"genere"}, $post_json->{"specie"}, $post_json->{"nome"}, $post_json->{"co2"}, $post_json->{"descrizione"});
    $PiantaDao->store($Pianta);

    $qrc = new QRCodeController();
    $qrcode = $qrc->getQRCodeUrl($Pianta, 200, 200);
    $Pianta->setQRCode($qrcode);
    $PiantaDao->updateQRCode($Pianta);

    $StatoPiantaDao = new StatoPiantaDao();
    $StatoPianta = new StatoPianta();
    
    $StatoPianta->setIdPianta($Pianta->getId());

    $StatoPiantaDao->store($StatoPianta);

  }

  // method that responde at PUT
  public function update($id = null)
  {
    // dopo 
  }
    
  // method that responde at DELETE
  public function delete($pianta)
  {
    $PiantaDao->delete($pianta);
  }
    
}