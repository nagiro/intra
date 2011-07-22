<?php

/**
 * Subclass for representing a row from the 'missatgesllistes' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Missatgesllistes extends BaseMissatgesllistes
{
        
	public function getLlistesArray()
	{
		$RET = array();
		$C = new Criteria();
		$C->add(LlistesPeer::IDLLISTES,$this->getLlistesIdllistes());
		foreach(LlistesPeer::doSelect($C) as $L):
			$RET[] = $L;
		endforeach;
		
		return $RET;
	}
}
