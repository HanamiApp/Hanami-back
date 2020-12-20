<?php


  namespace App\Services\Security;

  use \Firebase\JWT\JWT; 
  use App\Data\Dao\UserDao as UserDao;
  use App\Services\HTTP as HTTP;
  use App\Services\Logger as Logger;
  require_once __DIR__ . '/../../Data/Dao/UserDao.php';
  require_once __DIR__ . '/../../Services/HTTP.php';
  require_once __DIR__ . '/../../Services/Logger.php';
  require_once 'vendor/autoload.php';
  require_once 'vendor/firebase/php-jwt/src/BeforeValidException.php';
  require_once 'vendor/firebase/php-jwt/src/ExpiredException.php';
  require_once 'vendor/firebase/php-jwt/src/JWT.php';
  require_once 'vendor/firebase/php-jwt/src/SignatureInvalidException.php';


  class TokenManager
  {

    private static $UserDao;

    // metodo che genera un token JWT
    // TODO: togliere post_json parameter
    public static function generateJWT( $userId )
    {
      self::$UserDao = new UserDao();
      $secret = getenv('SECRET');

      $payload = json_encode([
        'sub' => $userId,
        'iat' => time(),
        //'exp' => time() + ( 60 * 5 ), // 5 minute expiration time
        'exp' => time() + ( 20 ), // expiration for testing
        'aud' => ['ALL']
      ]);

      $jwt = JWT::encode($payload, $secret);
      return $jwt;
    }
    
    // metodo che genera un refresh Token
    public static function generateRefreshJWT( $userId )
    {
      self::$UserDao = new UserDao();
      $refreshSecret = getenv('REFRESH_SECRET');   

      $payloadRefresh = json_encode([
        'sub' => $userId,
        'iat' => time(),
        //'exp' => time() + ( 60 * 60 ), // 1 hour expiration time
        'exp' => time() + ( 35 ), // expiration for testing
        'aud' => ['ALL']
      ]);

      $refreshJWT = JWT::encode($payloadRefresh, $refreshSecret);
      // prima di salvare il token nel database elimino ( se esiste ) quello vecchio
      self::invalidateRefreshJWT( $userId );
      // salviamo il token nel database
      self::$UserDao->storeRefreshToken($userId, $refreshJWT);
      return $refreshJWT;
    }

    // Metodo che verifica che un access token jwt sia valido
    public static function verifyJWT( $jwt, $refresh )
    {
      self::$UserDao = new UserDao();
      $secret = getenv('SECRET');
      $decoded = json_decode( JWT::decode( $jwt, $secret, ['HS256'] ) );
      
      //la scadenza deve essere nel futuro
      $exp = $decoded->exp > time();
      //iat deve essere nel passato
      $iat = $decoded->iat < time();

      if( $exp && $iat && !empty($decoded->sub) ) {
        // token valido
        Logger::add('TOKEN MANAGER: token valido');
        return self::$UserDao->getById($decoded->sub);
      } else if ( TokenManager::verifyRefreshJWT($refresh) ) {
        // rigenero token
        Logger::add('TOKEN MANAGER: token non valido, rigenero');
        $newJWT = TokenManager::generateJWT($decoded->sub);
        HTTP::setCookie(["token" => $newJWT, "refresh" => $refresh]);
        return self::$UserDao->getById($decoded->sub);
      } else {
        Logger::add('TOKEN MANAGER: token non valido');
        // non valido
        return null;
      }
    }

    // Metodo che verifica che un refresh token jwt sia valido
    public static function verifyRefreshJWT( $refreshJWT )
    {
      self::$UserDao = new UserDao();
      $refreshSecret = getenv('REFRESH_SECRET');
      $decoded = json_decode( JWT::decode( $refreshJWT, $refreshSecret, ['HS256'] ) );

      //la scadenza deve essere nel futuro
      $exp = $decoded->exp > time();
      //iat deve essere nel passato
      $iat = $decoded->iat < time();
      //il refreshToken dell'utente deve essere presente nel db
      $sub = $decoded->sub; // userID
      $userExist = null !== self::$UserDao->getRefreshToken($sub);

      if( $exp && $iat && $userExist ) return true;
      else{
        TokenManager::invalidateRefreshJWT($sub);
        return false;
      }
    }

    /* Metodo che invalida un refresh token
      * - quando vengono cambiati informazioni importanti nel profilo come password o email
      * - logout 
      */
    public static function invalidateRefreshJWT( $userId )
    {
      self::$UserDao = new UserDao();
      self::$UserDao->deleteRefreshToken($userId);
    }

  }


?>