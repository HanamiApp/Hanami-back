<?php


  namespace App\Services\Security;

  use \Firebase\JWT\JWT; 

  require_once 'vendor/autoload.php';
  require_once 'vendor/firebase/php-jwt/src/BeforeValidException.php';
  require_once 'vendor/firebase/php-jwt/src/ExpiredException.php';
  require_once 'vendor/firebase/php-jwt/src/SignatureInvalidException.php';
  require_once 'vendor/firebase/php-jwt/src/JWT.php';

  class TokenManager
  {

    static $validTokens = array();

    // metodo che genera un token JWT
    public static function generateJWT($post_json, $user)
    {
      $secret = getenv('SECRET');

      $payload = json_encode([
        'sub' => $user->getId(),
        'iat' => time(),
        'exp' => time() + ( 60 * 5 ), // 5 minute expiration time
        'aud' => ['ALL']
      ]);

      $jwt = JWT::encode($payload, $secret);
      return $jwt;
    }
    
    // metodo che genera un refresh Token
    public static function generateRefreshJWT( $post_json, $user )
    {
      $refreshSecret = getenv('REFRESH_SECRET');   

      $payloadRefresh = json_encode([
        'sub' => $user->getId(),
        'iat' => time(),
        'exp' => time() + ( 60 * 60 ), // 1 hour expiration time
        'aud' => ['ALL']
      ]);

      $refreshJWT = JWT::encode($payloadRefresh, $refreshSecret);
      $validTokens[$user->getId()] = $refreshJWT;
      echo "array:" . $validTokens[$user->getId()] . "=====";
      echo "refresh:" . $refreshJWT;
      return $refreshJWT;
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
        if( TokenManager::verifyRefreshJWT() ){
          TokenMagager::generateJWT($post_json, $decoded->sub);
        }else{
          echo "riloggati";
        }
      }
    }

    // Metodo che verifica che un refresh token jwt sia valido
    public static function verifyRefreshJWT( $refreshJWT )
    { 
      $refreshSecret = getenv('REFRESH_SECRET');
      $decoded = JWT::decode( $refreshJWT, $refreshSecret );
      //la scadenza deve essere nel futuro
      $exp = $decoded->exp > time();
      //iat deve essere nel passato
      $iat = $decoded->iat < time();
      //refreshJWT deve essere contenuto nell'array associativo
      $sub = in_array($refreshJWT, $validTokens);

      if( $exp && $iat && $sub ) return true;
      else{
        invalidateRefreshJWT($refreshJWT);
        return false;
      }         
    }

    /* Metodo che invalida un refresh token
      * - quando vengono cambiati informazioni importanti nel profilo come password o email
      * - logout 
      */
    public static function invalidateRefreshJWT( $refreshJWT )
    {
      $refreshSecret = getenv('REFRESH_SECRET');
      $decoded = JWT::decode( $refreshJWT, $refreshSecret );

      unset($validTokens[$decoded->sub]);
    }

  }


?>