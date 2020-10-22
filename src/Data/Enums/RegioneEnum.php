<?php


namespace App\Data\Enum;

abstract class RegioneEnum
{
  const ABRUZZO = 'abruzzo';
  const BASILICATA = 'basilicata';
  const CALABRIA = 'calabria';
  const CAMPANIA = 'campania';
  const EMILIA_ROMAGNA = 'emilia romagna';
  const FRIULI_VENEZIA_GIULIA = 'friuli-venezia giulia';
  const LAZIO = 'lazio';
  const LIGURIA = 'liguria';
  const LOMBARDIA = 'lombardia';
  const MARCHE = 'marche';
  const MOLISE = 'molise';
  const PIEMONTE = 'piemonte';
  const PUGLIA = 'puglia';
  const SARDEGNA = 'sardegna';
  const SICILIA = 'sicilia';
  const TOSCANA = 'toscana';
  const TRENTINO_ALTO_ADIGE = 'trentino-alto adige';
  const UMBRIA = 'umbria';
  const VALLE_D_AOSTA = 'valle d\'aosta';
  const VENETO = 'veneto';

  public static function getValueOf($key)
  {
    $class = new \ReflectionClass(__CLASS__);
    // se $key e null o non e presente allora ritorniamo 'DEFAULT
    return $class->getConstants()[$key];
  }

}

?>