<?php

  namespace App\Controllers;

  use App\Data\Dao\VehicleDao;
  use App\Data\DTO\VehicleDTO;
  use App\Services\HTTP;
  require_once __DIR__ . '/../Services/HTTP.php';
  require_once __DIR__ . '/../Data/DTO/VehicleDTO.php';
  require_once __DIR__ . '/../Data/Dao/VehicleDao.php';

  class VehicleController
  {

    private $VehicleDao;

    public function __construct()
    {
      $this->VehicleDao = new VehicleDao();
    }
    
    public function index() {
      $Vehicles = $this->VehicleDao->getAll();
      // converto
      $VehiclesDTO = array_map( function($Vehicle) {
        return new VehicleDTO($Vehicle);
      }, $Vehicles);
      HTTP::sendJsonResponse(200, $VehiclesDTO);
    }

    public function get( $id ) {
      if ( !isset($id) ) HTTP::sendJsonResponse(400, 'Wrong id provided');
      $Vehicle = $this->VehicleDao->getById($id);
      if ( !isset($Vehicle) ) HTTP::sendJsonResponse(404, "Vehicle with id ${id} not found");
      // response
      HTTP::sendJsonResponse(200, new VehicleDTO($Vehicle));
    }

    public function create() {
      $POST = (array)json_decode(file_get_contents('php://input'));
      $VehicleDTO = new VehicleDTO($POST);
      $Vehicle = $VehicleDTO->toEntity();
      // trasformo il nome del veicolo il lowercase
      $POST['name'] = strtolower($POST['name']);
      // controllo se c'e un veicolo con lo stesso nome
      if ( !empty($this->VehicleDao->getByName($POST['name'])) ) HTTP::sendJsonResponse(409, "Vehicle with provided name already exist");
      // posso fare l'inserimento
      $outcome = $this->VehicleDao->store($Vehicle);
      // response
      if ( !$outcome ) HTTP::sendJsonResponse(500);
      HTTP::sendJsonResponse(201, ["vehicleId" => $Vehicle->id]);
    }

    public function update( $id ) {
      $POST = (array)json_decode(file_get_contents('php://input'));
      // controllo se nel DB esiste l'id passato
      $DBVehicle = $this->VehicleDao->getById($id);
      if ( !isset($DBVehicle) ) HTTP::sendJsonResponse(404, "Vehicle with id ${id} not found");
      $VehicleDTO = new VehicleDTO($POST);
      $Vehicle = $VehicleDTO->toFilledEntity($DBVehicle);
      $outcome = $this->VehicleDao->update($Vehicle);
      if ( !$outcome ) HTTP::sendJsonResponse(500);
      HTTP::sendJsonResponse(200, "Vehicle with id ${id} updated");
    }

    public function delete( $id ) {
      if ( !isset($id) ) HTTP::sendJsonResponse(400, 'Wrong id provided');
      $DBVehicle = $this->VehicleDao->getById($id);
      if ( !isset($DBVehicle) ) HTTP::sendJsonResponse(404, "Vehicle with id ${id} not found");
      $outcome = $this->VehicleDao->delete($id);
      // response 
      if ( !$outcome ) HTTP::sendJsonResponse(500);
      HTTP::sendJsonResponse(205, "Vehicle with id ${id} deleted");
    }

  }

?>