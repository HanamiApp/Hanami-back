<?php


  namespace App\Data\Enum;

  class GruppoEnum
  {
    
    const OSPITE = 'ospite';
    const AMMINISTRATORE = 'amministratore';
    const GIARDINIERE = 'giardiniere';
    const DEFAULT = 'ospite';

    public static function getValueOf($key)
    {
      $class = new \ReflectionClass(__CLASS__);
      // se $key e null o non e presente allora ritorniamo 'DEFAULT
      if ( !array_key_exists($key, $class->getConstants()) ) return GruppoEnum::DEFAULT;
      return $class->getConstants()[$key];
    }

  }


?>