<?php

/**
 * Subclass for performing query and update operations on the 'TipusActivitat' table.
 *
 * 
 *
 * @package lib.model
 */ 
class TipusactivitatPeer extends BaseTipusactivitatPeer
{

  const T_CURS = 119;

  static public function getSelect()
    {
      $TA = self::doSelect(new Criteria());
      $ret = array();
      foreach($TA as $T)
      {
        $ret[$T->getIdtipusactivitat()] = $T->getNom();
      }
      
      return $ret;
    }
        

}
