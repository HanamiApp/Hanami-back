<?php


  namespace App\Services\Security;

  class TokenGenerator
  {

    private static $header;
    private static $secret;
    private static $payload;

    // metodo che genera un token JWT
    public static function generateJWT()
    {
      $this->secret = getenv('SECRET');
      $this->header = json_encode([
        'type' => 'JWT',
        'algo' => 'HS256' 
      ]);
      $this->payload = json_encode([
        'user_id' => '',
        'role' => ''
      ]);
      // encode the Header
      $base64UrlHeader = base64_encode($this->header);
      // encode the Payload
      $base64UrlPayload = base64_encode($this->payload);
      // create signature Hash
      $signature = hash_hmac('sha256', $base64UrlHeader . '.' . $base64UrlPayload, $secret, true);
      
    }

  }


?>