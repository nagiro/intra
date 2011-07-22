<?php

/**
 * Subclass for representing a row from the 'nodes' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Nodes extends BaseNodes
{

  static function Check()
  {
    $E = array();
    return $E;
  }
  
  public function getNomForUrl()
  {
    $nom = $this->getTitolmenu();
    return myUser::text2url($nom);
  }
  
}
