<?php

   namespace App\Controllers;

   use \Firebase\JWT\JWT;

   use App\Services\Security\RequestChecker as RequestChecker;
   use App\Services\Security\TokenManager as TokenManager;
   use App\Data\Dao\UserDao as UserDao;
   use App\Services\HTTP as HTTP;
   require_once __DIR__ . '/../Services/Security/RequestChecker.php';
   require_once __DIR__ . '/../Services/Security/TokenManager.php';
   require_once __DIR__ . '/../Data/Dao/UserDao.php';
   require_once __DIR__ . '/../Services/HTTP.php';


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
               TokenManager::invalidateRefreshJWT($post_json->{"refresh"});
               HTTP::sendJsonResponse(205, "User logged out");
               break;
         }         
      }

      public static function login( $post_json )
      {
         $UserDao = new UserDao();
         $User = $UserDao->getByEmail($post_json->{"email"});
         $userPassword = $User->password;
         $insertPassword = $post_json->{"password"};

         if( $User != null && ( $insertPassword == $userPassword ))
         {
            $token = TokenManager::generateJWT($User->id);
            $refreshToken = TokenManager::generateRefreshJWT($User->id);
            HTTP::sendJsonResponse(200, ["token" => $token, "refresh" => $refreshToken]);
         } else {
            HTTP::sendJsonResponse(400, "login error");
         }

      }

   }

?>