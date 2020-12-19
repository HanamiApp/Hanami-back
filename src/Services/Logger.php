<?php


  namespace App\Services;

  class Logger
  {

    public static $logs = Array();

    public static function add($log) {
      array_push(Logger::$logs, $log);
    }

    public static function all() {
      return Logger::$logs;
    }

  }


?>