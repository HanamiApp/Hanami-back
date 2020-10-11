<?php

   include __DIR__ . '/EnvLoader.php';

   class Database
   {
      // DB Params
      private $HOST;
      private $DB_NAME;
      private $USERNAME;
      private $PASSWORD;

      public function __construct()
      {
         $envLoader = new EnvLoader(__DIR__ . '/../../');
         $this->HOST = $envLoader->getVariable('HOST');
         $this->DB_NAME = $envLoader->getVariable('DB_NAME');
         $this->USERNAME = $envLoader->getVariable('MYSQL_USERNAME');
         $this->PASSWORD = $envLoader->getVariable('MYSQL_PASSWORD');
      }

   }


?>