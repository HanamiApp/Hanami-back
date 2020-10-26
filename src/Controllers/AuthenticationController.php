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
         $post_json = json_decode(file_get_contents('php://input'));
         switch($post_json->{"action"}){
            case "login":
               AuthenticationController::login($post_json);
               break;
            case "userRequest":
               AuthenticationController::verifyJWT($post_json->{"jwt"});
               break;
            case "logout":
               echo "logout";
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
            AuthenticationController::generateJWT($post_json, $user);
            AuthenticationController::generateRefreshJWT($post_json, $user);            
         }
      }

      public static function generateJWT( $post_json, $user )
      {
         $secret = getenv('SECRET');

         $payload = json_encode([
            'sub' => $user->getId(),
            'iat' => time(),
            'exp' => time() + ( 60 * 60 ), // 1 hour expiration time
            'aud' => ['ALL']
         ]);

         $jwt = JWT::encode($payload, $secret);
         echo $jwt;
      }

      public static function generateRefreshJWT( $post_json, $user )
      {
         $refreshSecret = getenv('REFRESH_SECRET');   

         $payloadRefresh = json_encode([
            'sub' => $user->getId(),
            'iat' => time(),
            'exp' => time() + ( 60 * 60 * 24 * 100), // 100 days expiration time
            'aud' => ['ALL']
         ]);

         $refreshJWT = JWT::encode($payloadRefresh, $refreshSecret);
         echo $refreshJWT;
      }

      // Metodo che verifica che un access token jwt sia valido
      public static function verifyJWT( $jwt )
      {
         $secret = getenv('SECRET');
         $decoded = JWT::decode( $jwt, $secret);

         //la scadenza deve essere nel futuro
         $exp = $decoded->exp > time();
         //iat deve essere nel passato
         $iat = $decoded->iat < time();
         if( $exp && $iat && !empty($decoded->sub) ){
            echo "jwt valido";
         }else{
            echo "jwt non valido";
            if( AutheticationController::verifyRefreshJWT() ){
               AuthenticationController::generateJWT($post_json, $decoded->sub);
            }else{
               echo "riloggati";
            }
         }
      }

      // Metodo che verifica che un refresh token jwt sia valido
      public static function verifyRefreshJWT( $refreshJWT )
      {  // TODO modificare
         $refreshSecret = getenv('REFRESH_SECRET');
         $decoded = JWT::decode( $refreshJWT, $refreshSecret );
         //la scadenza deve essere nel futuro
         $exp = $decoded->exp > time();
         //iat deve essere nel passato
         $iat = $decoded->iat < time();
         if( $exp && $iat && !empty($decoded->sub) ) return true;
         return false;          
      }

      /* Metodo che invalida un refresh token
      * - quando vengono cambiati informazioni importanti nel profilo come password o email
      * - 
      */
      public static function invalidateRefreshJWT()
      {

      }

   }

?>