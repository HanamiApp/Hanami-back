<?php

  namespace App\Controllers;

  class VehicleController
  {

    private $VehicleDao;

    public function __construct()
    {
      $this->VehicleDao = new VehicleDao();
    }

    
    public function index()
    {

    }

  }

?>