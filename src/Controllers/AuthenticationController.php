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
   require_once 'vendor/autoload.php';
   require_once 'vendor/firebase/php-jwt/src/BeforeValidException.php';
   require_once 'vendor/firebase/php-jwt/src/ExpiredException.php';
   require_once 'vendor/firebase/php-jwt/src/SignatureInvalidException.php';
   require_once 'vendor/firebase/php-jwt/src/JWT.php';

   class AuthenticationController
   {
      
      public function authenticate()
      {
         /*echo "authenticate!";
         $UtenteDao = new UtenteDao();
         $post_json = json_decode(file_get_contents('php://input'));
         $user = $UtenteDao->getUserByEmail($post_json->{"email"});
         $userPassword = $user->getPassword();
         $insertPassword = $post_json->{"password"};

         if( $user != null && ( $insertPassword == $userPassword )){
            echo "utenteValido";
            $jwt = TokenManager::generateJWT($user);
            $refresh_jwt = TokenManager::generateRefreshJWT($user);
            echo $jwt . "---------";
            echo $refresh_jwt;
            // TODO: mandare il token al frontend (per adesso con una echo)
         }            
         else{
            echo "utenteNonValido";
         }*/
         $post_json = json_decode(file_get_contents('php://input'));

         //fare un controllo sul tipo di action quindi se login o altro ?
         $UtenteDao = new UtenteDao();
         $user = $UtenteDao->getUserByEmail($post_json->{"email"});
         $userPassword = $user->getPassword();
         $insertPassword = $post_json->{"password"};

         if( $user != null && ( $insertPassword == $userPassword ))
         {
            $secret = getenv('SECRET');
            $refreshSecret = getenv('REFRESH_SECRET');

            $payload = json_encode([
               'sub' => $user->getId(),
               'iat' => time(),
               'exp' => time() + ( 60 * 60 ), // 1 hour expiration time
               'aud' => ['ALL']
            ]);

            $jwt = JWT::encode($payload, $secret);

            echo $jwt;               
         }
      }

      //TODO ogni richiesta che faccio deve controllare il token/sessione

   }

?>