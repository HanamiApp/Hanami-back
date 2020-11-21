<?php

   namespace App\Controllers;

   use \Firebase\JWT\JWT;

   use App\Services\Security\RequestChecker as RequestChecker;
   use App\Services\Security\TokenManager as TokenManager;
   use App\Data\Entities\Utente;
   use App\Data\Dao\UtenteDao as UtenteDao;
   require_once __DIR__ . '/../Services/Security/RequestChecker.php';
   require_once __DIR__ . '/../Services/Security/TokenManager.php';
   require_once __DIR__ . '/../Data/Entities/Utente.php';
   require_once __DIR__ . '/../Data/Dao/UtenteDao.php';

   class AuthenticationController
   {
      // Metodo che gestisce una richiesta in arrivo
      public function authenticate()
      {
         $post_json = json_decode(file_get_contents('php://input'));
         switch($post_json->{"action"}){
            case "login":
               AuthenticationController::login($post_json);
               break;
            case "userRequest":
               TokenManager::verifyJWT($post_json->{"jwt"});
               break;
            case "logout":
               TokenManager::invalidateRefreshJWT($post_json->{"refreshJWT"});
               break;
         }         
      }

      public static function login( $post_json )
      {
         $UtenteDao = new UtenteDao();
         $user = $UtenteDao->getUserByEmail($post_json->{"email"});
         $userPassword = $user->getPassword();
         $insertPassword = $post_json->{"password"};

         if( $user != null && ( $insertPassword == $userPassword ))
         {
            $token = TokenManager::generateJWT($user->getId());
            $refreshToken = TokenManager::generateRefreshJWT($user->getId());
            echo "token:" . $token . "refreshToken:" . $refreshToken;
         }
      }

   }

?>