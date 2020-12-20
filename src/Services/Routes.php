<?php

  namespace App\Services;

  class Routes
  {

    // GET
    public static $GET_ROUTES = [
      "/users/me"           => "UserController@me:[ALL]",
      "/users/:id"          => "UserController@get:[ALL]",
      "/users"              => "UserController@index:[ALL]",
      "/plants"             => "PlantController@index:[ALL]",
      "/plants/:id"         => "PlantController@get:[ALL]",
      "/species"            => "SpeciesController@index:[ALL]",
      "/genus/:id"          => "GenusController@get:[ALL]",
      "/photo/:file_name"   => "PhotoController@getPhoto:[ALL]"
    ];
    // POST
    public static $POST_ROUTES = [
      "/users"              => "UserController@create",
      "/login"              => "AuthenticationController@login",
      "/logout"             => "AuthenticationController@logout:[ALL]",
      "/plants"             => "PlantController@create:[ALL]",
      "/species/search"     => "SpeciesController@search:[ALL]"
    ];
    // PUT
    public static $PUT_ROUTES = [
      "/users/:id"          => "UserController@update:[ALL]"
    ];
    // PATCH
    public static $PATCH_ROUTES = [];
    // DELETE
    public static $DELETE_ROUTES = [
      "/users/:id"          => "UserController@delete:[ALL]"
    ];

  }

?>