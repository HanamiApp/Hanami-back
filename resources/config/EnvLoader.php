<?php


class EnvLoader
{
   // Class variables
   private $pathToEnvFile;
   private $MY_ENV = Array();
   
   // costruttore
   public function __construct($path)
   {
      $this->pathToEnvFile = $path;
      $this->loadEnvVariables();
   }

   // methods
   private function loadEnvVariables()
   {
      $envFile = file($this->pathToEnvFile . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      foreach($envFile as $variable) {
         $splitted = explode('=', $variable);
         $this->MY_ENV[$splitted[0]] = $splitted[1];
      }
   }

   public function getVariable($key)
   {
      return $this->MY_ENV[$key];
   }

}


?>