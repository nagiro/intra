<?php

/**
 * Subclass for representing a row from the 'usuarisllistes' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Usuarisllistes extends BaseUsuarisllistes
{
   
   static function getLlistesUsuari($idU)
   {
      $C = new Criteria();
      $C->add(UsuarisllistesPeer::IDUSUARISLLISTES , $idU);
      return UsuarisllistesPeer::doSelect($C);
   }
   
}
