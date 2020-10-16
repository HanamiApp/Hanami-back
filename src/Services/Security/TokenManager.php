<?php


  namespace App\Services\Security;

  class TokenManager
  {

    // metodo che genera un token JWT
    public static function generateJWT($Utente)
    {
      $secret = getenv('SECRET');
      $header = json_encode([
        'type' => 'JWT',
        'algo' => 'HS256' 
      ]);
      $payload = json_encode([
        'sub' => $Utente->getId(),
        'iat' => time(),
        'exp' => time() + ( 60 * 60 ), // 1 hour expiration time
        'aud' => ['ALL']
      ]);
      // encode the Header
      $base64UrlHeader = base64_encode($header);
      // encode the Payload
      $base64UrlPayload = base64_encode($payload);
      // create signature Hash
      $signature = hash_hmac('sha256', $base64UrlHeader . '.' . $base64UrlPayload, $secret, true);
      $base64UrlSignature = base64_encode($signature);
      // JWT = header.payload.signature
      $jwt = $base64UrlHeader . '.' . $base64UrlPayload . '.' . $base64UrlSignature;
      return $jwt;
    }

    // metodo che valida il token JWT dato
    public static function validateJWT($jwt)
    {
      $tokenParts = explode('.', $jwt);
      $header = base64_decode($tokenParts[0]);
      $payload = base64_decode($tokenParts[1]);
      $signatureProvided = $tokenParts[2];

      // Controlliamo se il Token e scaduto ( expired )
      if ( $_SERVER['REQUEST_TIME'] > json_decode($payload)->{'exp'} ) return false;
      
      // riproduciamo la signature da header, payload e secret
      $secret = getenv('SECRET');
      $base64UrlHeader = base64_encode($header);
      $base64UrlPayload = base64_encode($payload);
      $signature = hash_hmac('sha256', $base64UrlHeader . '.' . $base64UrlPayload, $secret, true);
      $base64UrlSignature = base64_encode($signature);

      $isSignatureValid = ( $base64UrlSignature === $signatureProvided );

      if ( $isSignatureValid ) return true;
      return false;
    }

  }


?>