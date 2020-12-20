<?php

   namespace App\Controllers;

   use App\Services\Security\TokenManager as TokenManager;
   use App\Data\Dao\UserDao as UserDao;
   use App\Services\HTTP as HTTP;
   require_once __DIR__ . '/../Services/Logger.php';
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
            HTTP::sendJsonResponse(200, ["userId" => $User->id], ["token" => $token, "refresh" => $refreshToken]);
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

      public static function validateRequest( $permissions )
      {
         if ( count($permissions) === 0 ) return;
         $cookieData = json_decode(str_replace("tokens=", "", urldecode($_SERVER['HTTP_COOKIE'])));
         $token = $cookieData->token;
         $refresh = $cookieData->refresh;
         $User = TokenManager::verifyJWT($token, $refresh);
         $_SESSION['user_id'] = $User->id;
         $isAuthorized = true;
         if( !isset($User) || !$isAuthorized ) {
            HTTP::sendJsonResponse(401, "Azione non autorizzata");
         }
      }
   }

?>