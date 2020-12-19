<?php

  // Questo controller si occupa di creare la scheda riepilogativa dell'albero

  namespace App\Controllers;
  use App\Data\Dao\UpdateDao as UpdateDao;
  use App\Data\Dao\UserDao as UserDao;
  use App\Services\HTTP as HTTP;
  require_once __DIR__ . '/../Data/Dao/UpdateDao.php';
  require_once __DIR__ . '/../Data/Dao/UserDao.php';
  require_once __DIR__ . '/../Services/HTTP.php';


  class TreeCardCreator
  {

    public function createCard( ...$params )
    {
      $id_plant = $params[0];
      // prendiamo gli 'aggiornamenti' fatti all'albero con l'id fornito
      $UpdateDao = new UpdateDao();
      $UserDao = new UserDao();
      // lista di aggiornamenti
      $updateList = $UpdateDao->getUpdatesByPlantId($id_plant);
      
      $u = [];
      foreach($updateList as $up) {
        array_push($u, [$up->__toString(), $UserDao->getById($up->getId())->__toString()]);
      }
      HTTP::sendJsonResponse(202, $u);

    }

  }

?>