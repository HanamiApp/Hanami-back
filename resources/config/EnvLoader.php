<?php


class EnvLoader
{
   // method that load all local variables  
   public static function load()
   {
      $envFile = file($_SERVER['DOCUMENT_ROOT'] . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      foreach($envFile as $variable) {
         putenv($variable);
      }
   }

}


?>