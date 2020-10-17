<?php


  namespace App\Services;

  class HTTP
  {

    const HTTP_VERSION = '1.1';
    const HTTP_STATUS = [
      200 => 'OK',
      201 => 'Created',
      202 => 'Accepted',
      400 => 'Bad Request',
      401 => 'Unauthorized',
      403 => 'Forbidden',
      404 => 'Not Found',
      405 => 'Method Not Allowed',
      408 => 'Request Timeout',
      415 => 'Unsupported Media Type',
      500 => 'Internal Server Error',
      501 => 'Not Implemented'
    ];

    public static function sendJsonResponse($code, $message)
    {
      header('Content-Type: application/json');
      header("HTTP/" . HTTP::HTTP_VERSION . " {$code} " . HTTP::HTTP_STATUS[$code]);
      echo json_encode($message);
    }

  }


?>