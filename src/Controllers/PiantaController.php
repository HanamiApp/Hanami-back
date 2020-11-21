<?php

  namespace App\Controllers;
  use App\Data\Entities\Pianta;
  use App\Data\Models\StatoPianta;
  use App\Data\Dao\PiantaDao as PiantaDao;
  use App\Data\Dao\StatoPiantaDao as StatoPiantaDao;
  use App\Controllers\QRCodeController as QRCodeController;
  require_once __DIR__ . '/../Data/Entities/Pianta.php';
  require_once __DIR__ . '/../Data/Dao/PiantaDao.php';
  require_once __DIR__ . '/../Data/Models/StatoPianta.php';
  require_once __DIR__ . '/../Data/Dao/StatoPiantaDao.php';
  require_once __DIR__ . '/QRCodeController.php';

  class PiantaController{

  //metodo per la GET
  public static function get($id)
  {
    $PiantaDao = new PiantaDao();
    $StatoPiantaDao = new StatoPiantaDao();

    $StatoPianta = $PiantaDao->getPianta($id);
    echo json_encode($StatoPianta->__toString());
  }

  //metodo per la POST
  public static function create()
  {

    $POST = (array)json_decode(file_get_contents('php://input'));
    $PiantaDao = new PiantaDao();
    //check campi inseriti dall'utente che crea la pianta
    
    if($POST['genere'] === null || $POST['specie'] === null)
      die("WARNING: missing_values_for_genere_or_specie");
    if($POST['nome'] === null || $POST['co2'] === null || $POST['descrizione'] === null)
      die("ERROR: missing_values_for_nome_or_co2_or_descrizione");

    // plant creation
    $Pianta = new Pianta($POST['genere'], $POST['specie'], $POST['nome'], $POST['co2'], $POST['descrizione']);
    $PiantaDao->store($Pianta);

    //creazione qrcode
    $qrc = new QRCodeController();
    $qrcode = $qrc->getQRCodeUrl($Pianta, 200, 200);
    $Pianta->setQRCode($qrcode);
    $PiantaDao->updateQRCode($Pianta);

    //inserimento campi stato pianta
    $StatoPiantaDao = new StatoPiantaDao();
    $StatoPianta = new StatoPianta($Pianta->getGenere(), $Pianta->getSpecie(), $Pianta->getNome(), $Pianta->getCo2(), $Pianta->getDescrizione());
    $StatoPianta->setQRCode($Pianta->getQRCode());
    $StatoPianta->setId($Pianta->getId());

    //store della pianta e stato_pianta nel database
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
    //
  }
    
}