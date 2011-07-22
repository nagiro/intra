<?php

/**
 * Subclass for performing query and update operations on the 'poblacions' table.
 *
 * 
 *
 * @package lib.model
 */ 
class PoblacionsPeer extends BasePoblacionsPeer
{
  static public function select()
  {
    $C = new Criteria();
    $C->addAscendingOrderByColumn(self::NOM);
    $PO = self::doSelect($C);
    $RET = array();
    $RET[-1] = ' ';
    foreach($PO as $P):         
      $RET[$P->getIdpoblacio()] = $P->getNom();    
    endforeach;
    
    return $RET;          
  }
  
}
