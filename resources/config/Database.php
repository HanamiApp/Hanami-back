<?php


   namespace App\Resources\Config;

   use \PDO  as PDO;

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
         $this->HOST = getenv('HOST');
         $this->DB_NAME = getenv('DB_NAME');
         $this->USERNAME = getenv('MYSQL_USERNAME');
         $this->PASSWORD = getenv('MYSQL_PASSWORD');
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
            // errore
         }
         return $this->connection;
      }

   }


?>