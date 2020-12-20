<?php

  namespace App\Data\DTO;

  use App\Services\Logger;
  use App\Services\HTTP;
  require_once __DIR__ . '/../../Services/HTTP.php';
  require_once __DIR__ . '/../../Services/Logger.php';

  class SearchDTO
  {

    private $filterBy = [];

    public function __construct( $Input )
    {
      if ( !is_array($Input) ) $Input = $Input->__toArray();
      $this->filterBy = $Input['filterBy'];
    }

    public function getFilters()
    {
      $filters = [];
      foreach ( $this->filterBy as $filter ) {
        $filters[key($filter)] = $filter->{key($filter)};
      }
      return $filters;
    }

  }

?>