<?php

  namespace App\Controllers;

  use App\Data\Dao\GenusDao;
  require_once __DIR__ . '/../Data/Dao/GenusDao.php';

  class GenusController
  {

    private $GenusDao;

    public function __construct()
    {
      $this->GenusDao = new GenusDao();
    }


    public function get( $id )
    {
      $this->GenusDao->get( $id );
    }

  }

?>