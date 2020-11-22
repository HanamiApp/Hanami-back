<?php


  namespace App\Services\Security;

  use \Firebase\JWT\JWT; 
  use App\Data\Dao\UserDao as UserDao;
  require_once 'vendor/autoload.php';
  require_once 'vendor/firebase/php-jwt/src/BeforeValidException.php';
  require_once 'vendor/firebase/php-jwt/src/ExpiredException.php';
  require_once 'vendor/firebase/php-jwt/src/SignatureInvalidException.php';
  require_once 'vendor/firebase/php-jwt/src/JWT.php';
  require_once __DIR__ . '/../../Data/Dao/UserDao.php';


  class TokenManager
  {

    // metodo che genera un token JWT
    // TODO: togliere post_json parameter
    public static function generateJWT( $userId )
    {
      $secret = getenv('SECRET');

      $payload = json_encode([
        'sub' => $userId,
        'iat' => time(),
        //'exp' => time() + ( 60 * 5 ), // 5 minute expiration time
        'exp' => time() + ( 40 ), // expiration for testing
        'aud' => ['ALL']
      ]);

      $jwt = JWT::encode($payload, $secret);
      return $jwt;
    }
    
    // metodo che genera un refresh Token
    public static function generateRefreshJWT( $userId )
    {
      $refreshSecret = getenv('REFRESH_SECRET');   

      $payloadRefresh = json_encode([
        'sub' => $userId,
        'iat' => time(),
        //'exp' => time() + ( 60 * 60 ), // 1 hour expiration time
        'exp' => time() + ( 60 ), // expiration for testing
        'aud' => ['ALL']
      ]);

      $refreshJWT = JWT::encode($payloadRefresh, $refreshSecret);
      $UserDao = new UserDao();
      // salviamo il token nel database
      $UserDao->storeRefreshToken($userId, $refreshJWT);
      return $refreshJWT;
    }

    // Metodo che verifica che un access token jwt sia valido
    public static function verifyJWT( $jwt )
    {
      print_r($validTokens);
      $secret = getenv('SECRET');
      $decoded = json_decode( JWT::decode( $jwt, $secret, ['HS256'] ) );
      $POST = (array)json_decode(file_get_contents('php://input'));

      //la scadenza deve essere nel futuro
      $exp = $decoded->exp > time();
      //iat deve essere nel passato
      $iat = $decoded->iat < time();
      if( $exp && $iat && !empty($decoded->sub) ){
        echo "jwt valido";
      }else{
        echo "jwt non valido";
        if( TokenManager::verifyRefreshJWT($POST['refresh']) ){
          echo "rigenero token";
          echo TokenManager::generateJWT($decoded->sub);
        }else{
          echo "riloggati";
        }
      }
    }

    // Metodo che verifica che un refresh token jwt sia valido
    public static function verifyRefreshJWT( $refreshJWT )
    { 
      $refreshSecret = getenv('REFRESH_SECRET');
      $decoded = json_decode( JWT::decode( $refreshJWT, $refreshSecret, ['HS256'] ) );

      //la scadenza deve essere nel futuro
      $exp = $decoded->exp > time();
      //iat deve essere nel passato
      $iat = $decoded->iat < time();
      //refreshJWT deve essere contenuto nell'array associativo
      //$sub = in_array($refreshJWT, $validTokens);
      $sub = $decoded->sub; // userID
      $UserDao = new UserDao();
      $userExist = null !== $UserDao->getRefreshToken($sub);

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
      $UserDao = new UserDao();
      $UserDao->deleteRefreshToken($userId);
    }

  }


?>