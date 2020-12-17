<?php

  namespace App\Services;

  class Routes
  {

    public const ROUTES = [
      "/users/me" => "UserController@me",
      "/plants" => "PlantController@index",
      "/plants/{id}" => "PlantController@get"
    ];

  }

?>