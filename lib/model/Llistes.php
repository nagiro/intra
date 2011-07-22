<?php

/**
 * Subclass for representing a row from the 'llistes' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Llistes extends BaseLlistes
{
	
	public function getMailsUsuaris()
	{
		
		$RET = array();
		$IDL = $this->getIdllistes();        
		$C = new Criteria();
		$C->add(UsuarisllistesPeer::LLISTES_IDLLISTES,$IDL);
		$C->addJoin(UsuarisllistesPeer::USUARIS_USUARISID, UsuarisPeer::USUARIID);
		
		foreach(UsuarisPeer::doSelect($C) as $U):
			$RET[$U->getEmail()] = $U->getEmail();
		endforeach;
		
		return $RET;
		
	}
	
}
