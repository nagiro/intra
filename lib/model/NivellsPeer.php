<?php

/**
 * Subclass for performing query and update operations on the 'nivells' table.
 *
 * 
 *
 * @package lib.model
 */ 
class NivellsPeer extends BaseNivellsPeer
{
  const SUPER_ADMIN = 999;
  const CREACIO = 7;
  const CAP = 6;
  const ANTICSMATRICULATS = 5;
  const CONSULTA = 4; 
  const EDICIO = 3; 
  const REGISTRAT = 2; 
  const ADMIN = 1;
	
  static function getSelect()
  {
    
    $nivells = self::doSelect(new Criteria());
    $ret = array();
    foreach($nivells as $N)
    {        
      $ret[$N->getIdnivells()] = $N->getNom();
      //El nivell superadministrador no es pot escollir mai. 
      unset($ret[self::SUPER_ADMIN]);
    }
    return $ret;
        
  }

  //Retorna els permisos per a una aplicació que utilitza lectura, escriptura
  static function getSelectPermisos()
  {  
  	return array(self::CAP=>'Cap',self::EDICIO=>'Escriptura',self::CONSULTA=>'Lectura');  	
  }
  
  
}
