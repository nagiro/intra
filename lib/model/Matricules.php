<?php

/**
 * Subclass for representing a row from the 'matricules' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Matricules extends BaseMatricules
{

  static function Check($new)
  {
    $E = array();    
    return $E;    
  }    
  
  public function getTpagamentString()
  {
  	return MatriculesPeer::textPagament($this->getTpagament());
  }
  
  public function getTreduccioString()
  {  
  	return MatriculesPeer::textDescomptes($this->getTreduccio());  	
  }
  
  public function getEstatString()
  {  
  	return MatriculesPeer::getEstatText($this->getEstat());  	
  }
 

}
