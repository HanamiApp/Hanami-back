<?php

   namespace App\Controllers;
   use App\Data\Entities\Pianta;
   use App\Data\Dao\PiantaDao as UtenteDao;
   require_once __DIR__ . '/../Data/Entities/Pianta.php';
   require_once __DIR__ . '/../Data/Dao/PiantaDao.php';

   class PiantaController{

   //metodo per la GET
   public function create()
   {
      // forse va bene? chi lo sa!
      RequestChecker::validateRequest();
      $PiantaDAO = new PiantaDAO();
      $genere = $_GET['genere'];
      $specie = $_GET['specie'];
      $nome = $_GET['nome'];
      $co2 = $_GET['co2'];
      $descrizione = $_GET['descrizione'];
      // plant creation
      $Pianta = new Pianta($genere, $specie, $nome, $co2, $descrizione);
      $PiantaDao->store($Pianta);
   }

    // method that responde at PUT
    public function update($id = null)
    {
      //da fare sta cosa non so come si gestiscono i dati con la UPDATE
    }
    
    // method that responde at DELETE
    public function delete($id = null)
    {
      // idem
    }
    
  }