<?php

  // Questo controller si occupa di creare la scheda riepilogativa dell'albero

  namespace App\Controllers;
  use App\Data\Dao\UpdateDao as UpdateDao;
  use App\Services\HTTP as HTTP;
  require_once __DIR__ . '/../Data/Dao/UpdateDao.php';
  require_once __DIR__ . '/../Services/HTTP.php';


  class TreeCardCreator
  {

    public function createCard($id_tree)
    {

      // prendiamo gli 'aggiornamenti' fatti all'albero con l'id fornito
      $UpdateDao = new UpdateDao();
      // lista di aggiornamenti
      $updateList = $UpdateDao->getUpdatesByTreeId($id_tree);
      HTTP::sendJsonResponse(202, 'messaggio');

    }

  }

?>