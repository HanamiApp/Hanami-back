<?php


   include __DIR__ . '/EnvLoader.php';

   class Database
   {
      // DB Params
      private $HOST;
      private $DB_NAME;
      private $USERNAME;
      private $PASSWORD;
      private $connection = null;

      public function __construct()
      {
         $envLoader = new EnvLoader(__DIR__ . '/../../');
         $this->HOST = $envLoader->getVariable('HOST');
         $this->DB_NAME = $envLoader->getVariable('DB_NAME');
         $this->USERNAME = $envLoader->getVariable('MYSQL_USERNAME');
         $this->PASSWORD = $envLoader->getVariable('MYSQL_PASSWORD');
      }

      public function connect()
      {
         $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_CASE => PDO::CASE_NATURAL,
            PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING
         ];
         try {
            $this->connection = new PDO("mysql:host={$this->HOST}; dbname={$this->DB_NAME}", $this->USERNAME, $this->PASSWORD, $options);
            // settiamo la connessione in modo che sollevi un eccezione algi errori dati dagli attributi
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         } catch ( PDOException $e ) {
            echo 'Database Connection Error: ' . $e->getMessage();
         }
         return $this->connection;
      }

   }


?>