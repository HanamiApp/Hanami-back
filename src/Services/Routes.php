<?php

  namespace App\Services;

  class Routes
  {

    // GET
    public static $GET_ROUTES = [
      "/users/me"       => "UserController@me",
      "/users/:id"     => "UserController@get",
      "/users"          => "UserController@index"
    ];
    // POST
    public static $POST_ROUTES = [
      "/users"          => "UserController@create"
    ];
    // PUT
    public static $PUT_ROUTES = [
      "/users/:id"     => "UserController@update"
    ];
    // PATCH
    public static $PATCH_ROUTES = [];
    // DELETE
    public static $DELETE_ROUTES = [
      "/users/:id"     => "UserController@delete"
    ];

  }

?>