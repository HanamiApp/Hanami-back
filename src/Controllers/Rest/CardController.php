<?php


  namespace App\Controllers\Rest;
  use App\Services\Security\RequestChecker as RequestChecker;
  use App\Controllers\TreeCardCreator as TreeCardCreator;
  require_once __DIR__ . '/../../Services/Security/RequestChecker.php';
  require_once __DIR__ . '/TreeCardCreator.php';


  class CardController
  {
    // method that responde at GET with all users
    public function index()
    {
      echo "Card index";
    }
    // method that responde at GET with the user correspond at given id
    public function get($id = null)
    {
      if ( $id == null ) die('WrongIdProvided'); 
      $TreeCard = new TreeCardCreator();
      $TreeCard->createCard($id);
    }
    // method that responde at POST ( registration method )
    public function create()
    {
      echo "Card create";
    }
    // method that responde at PUT
    public function update($id = null)
    {
      RequestChecker::validateRequest();
      if ( $id == null ) die('WrongIdProvided'); 
      echo "Card update, id: ${id}";
    }
    // method that responde at DELETE
    public function delete($id = null)
    {
      RequestChecker::validateRequest();
      if ( $id == null ) die('WrongIdProvided'); 
      echo "Card delete, id: ${id}";
    }
    
  }
  

?>