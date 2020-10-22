<?php
   
   namespace App\Controllers;
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
      
      public function authenticate()
      {
         echo "authenticate!";
         $UtenteDao = new UtenteDao();
         $post_json = json_decode(file_get_contents('php://input'));
         $user = $UtenteDao->getUserByEmail($post_json->{"email"});
         $userPassword = $user->getPassword();
         $insertPassword = $post_json->{"password"};

         if( $user != null && ( $insertPassword == $userPassword )){
            echo "utenteValido";
            $jwt = $TokenManager::generateJWT($user);
            $refresh_jwt = $TokenManager::generateRefreshJWT($user);
            echo $jwt;
            echo $refresh_jwt;
            // TODO: mandare il token al frontend (per adesso con una echo)
         }            
         else{
            echo "utenteNonValido";
         }
      }

      //TODO ogni richiesta che faccio deve controllare il token/sessione

   }

?>