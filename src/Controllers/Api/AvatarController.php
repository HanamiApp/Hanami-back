<?php

  namespace App\Controllers\Api;

  use App\Services\HTTP;
  require_once __DIR__ . '/../../Services/HTTP.php';

  class AvatarController
  {

    const URI = 'https://icotar.com/avatar';

    public static function getRandomPNGAvatar()
    {
      $url = self::URI . '/' . self::_generateRandomString() . '.png';
      $avatar = file_get_contents($url);
      return $avatar;
    }

    private static function _generateRandomString($length = 20) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
  }

  }

?>