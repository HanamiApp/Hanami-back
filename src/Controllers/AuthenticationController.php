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
         echo "authenticate";
         //RequestChecker::validateRequest();
         $UtenteDao = new UtenteDao();
         $post_json = json_decode(file_get_contents('php://input'));
         $user = $UtenteDao->getUserByEmail($post_json->{"email"});
         $userPassword = $user->getPassword();
         $insertPassword = $post_json->{"password"};

         if( $utente != null && ( $insertPassword == $userPassword ))
            echo "utenteValido"; 
         else echo "utenteNonValido";

         # assegnare un token e un refresh token 
         // salvare token nel db? 
         # mandare il token al front end 
      }
   }

?>