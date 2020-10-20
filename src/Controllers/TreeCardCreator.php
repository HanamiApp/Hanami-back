<?php

  // Questo controller si occupa di creare la scheda riepilogativa dell'albero

  namespace App\Controllers;
  use App\Data\Dao\UpdateDao as UpdateDao;
  use App\Data\Dao\UtenteDao as UtenteDao;
  use App\Services\HTTP as HTTP;
  require_once __DIR__ . '/../Data/Dao/UpdateDao.php';
  require_once __DIR__ . '/../Data/Dao/UtenteDao.php';
  require_once __DIR__ . '/../Services/HTTP.php';


  class TreeCardCreator
  {

    public function createCard($id_tree)
    {

      // prendiamo gli 'aggiornamenti' fatti all'albero con l'id fornito
      $UpdateDao = new UpdateDao();
      $UtenteDao = new UtenteDao();
      // lista di aggiornamenti
      $updateList = $UpdateDao->getUpdatesByTreeId($id_tree);
      

      $u = [];
      foreach($updateList as $up) {
        array_push($u, [$up->__toString(), $UtenteDao->getById($up->getIdUtente())->__toString()]);
      }
      HTTP::sendJsonResponse(202, $u);

    }

  }

?>