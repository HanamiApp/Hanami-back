<?php


  namespace App\Controllers;
  use App\Services\Security\RequestChecker as RequestChecker;
  use App\Services\Security\TokenManager as TokenManager;
  use App\Data\Entities\Utente;
  use App\Data\Enums\GruppoEnum as GruppoEnum;
  use App\Data\Dao\UtenteDao as UtenteDao;
  use App\Data\Dao\GruppoDao as GruppoDao;
  require_once __DIR__ . '/../Services/Security/RequestChecker.php';
  require_once __DIR__ . '/../Services/Security/TokenManager.php';
  require_once __DIR__ . '/../Data/Entities/Utente.php';
  require_once __DIR__ . '/../Data/Enums/GruppoEnum.php';
  require_once __DIR__ . '/../Data/Dao/UtenteDao.php';
  require_once __DIR__ . '/../Data/Dao/GruppoDao.php';

  class UtenteController
  {
    // method that responde at GET with all users
    public function index()
    {
      echo "User index";
    }
    // method that responde at GET with the user correspond at given id
    public function get($id = null)
    {
      if ( $id == null ) die('WrongIdProvided'); 
      echo "User get";
    }
    // method that responde at POST ( registration method )
    public function create()
    {
      // TODO: password hashing
      // TODO: informarsi se il token deve essere messo nel DB
      RequestChecker::validateRequest();
      $UtenteDao = new UtenteDao();
      $GruppoDao = new GruppoDao();
      $post_json = json_decode(file_get_contents('php://input'));
      $POST = (array)$post_json;
      // user creation
      $Utente = new Utente($POST['nome'], $POST['cognome'], $POST['email'], $POST['password'], $POST['regione']);
      $gruppo = empty($POST['gruppo']) ? GruppoEnum::OSPITE : GruppoEnum::getValueOf($POST['gruppo']);
      $UtenteDao->store($Utente);
      $Gruppo = $GruppoDao->getByNome($gruppo);
      $GruppoDao->connectUtente($Gruppo, $Utente);
      echo TokenManager::generateJWT($Utente);
    }
    // method that responde at PUT
    public function update($id = null)
    {
      RequestChecker::validateRequest();
      if ( $id == null ) die('WrongIdProvided'); 
      echo "User update, id: ${id}";
    }
    // method that responde at DELETE
    public function delete($id = null)
    {
      RequestChecker::validateRequest();
      if ( $id == null || gettype($id) != 'integer' ) die('WrongIdProvided'); 
      echo "User delete, id: ${id}";
    }
    
  }
  

?>