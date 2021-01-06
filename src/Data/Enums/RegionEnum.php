<?php


  namespace App\Data\Enums;

  // TODO: vedere come cambiare enum
  abstract class RegionEnum
  {
    const ABRUZZO = 'Abruzzo';
    const BASILICATA = 'Basilicata';
    const CALABRIA = 'Calabria';
    const CAMPANIA = 'Campania';
    const EMILIA_ROMAGNA = 'Emilia Romagna';
    const FRIULI_VENEZIA_GIULIA = 'Friuli-Venezia Giulia';
    const LAZIO = 'Lazio';
    const LIGURIA = 'Liguria';
    const LOMBARDIA = 'Lombardia';
    const MARCHE = 'Marche';
    const MOLISE = 'Molise';
    const PIEMONTE = 'Piemonte';
    const PUGLIA = 'Puglia';
    const SARDEGNA = 'Sardegna';
    const SICILIA = 'Sicilia';
    const TOSCANA = 'Toscana';
    const TRENTINO_ALTO_ADIGE = 'Trentino-Alto Adige';
    const UMBRIA = 'Umbria';
    const VALLE_D_AOSTA = 'Valle D\'Aosta';
    const VENETO = 'Veneto';

    public static function getValueOf($key)
    {;
      $class = new \ReflectionClass(__CLASS__);
      // se $key e null o non e presente allora ritorniamo 'DEFAULT
      return $class->getConstants()[$key];
    }

  }


?>