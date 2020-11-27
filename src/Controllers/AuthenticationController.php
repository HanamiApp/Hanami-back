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

      public static function login()
      {
         $post_json = json_decode(file_get_contents('php://input'));
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

      public static function logout()
      {
         $post_json = json_decode(file_get_contents('php://input'));
         $UserDao = new UserDao();
         $User = $UserDao->getByEmail($post_json->{"email"});
         TokenManager::invalidateRefreshJWT($User->id);
         HTTP::sendJsonResponse(205, "User logged out");
      }

      public static function userRequest()
      {
         $post_json = json_decode(file_get_contents('php://input'));
         $user = TokenManager::verifyJWT($post_json->{"jwt"});
         if( $user != null )
         {
            HTTP::sendJsonResponse(200, ["user" => $user]);
         } else {
            HTTP::sendJsonResponse(400, "UserRequest error");
         }
      }
   }

?>