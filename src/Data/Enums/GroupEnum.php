<?php


  namespace App\Data\Enums;

  class GroupEnum
  {
    
  // TODO: vedere come cambiare enum
    const GUEST = 'guest';
    const ADMIN = 'admin';
    const GARDENER = 'gardener';
    const DEFAULT = 'guest';

    public static function getValueOf($key)
    {
      $class = new \ReflectionClass(__CLASS__);
      // se $key e null o non e presente allora ritorniamo 'DEFAULT
      if ( !array_key_exists($key, $class->getConstants()) ) return GroupEnum::DEFAULT;
      return $class->getConstants()[$key];
    }

  }


?>