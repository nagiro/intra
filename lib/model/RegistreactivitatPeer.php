<?php

/**
 * Subclass for performing query and update operations on the 'registreactivitat' table.
 *
 * 
 *
 * @package lib.model
 */ 
class RegistreactivitatPeer extends BaseRegistreactivitatPeer
{

	const INSERT = 'I';
	const DELETE = 'D';
	const UPDATE = 'U';
	const BAIXAUSUARIENTITAT = 'BaixaUsuariEntitat';
	const ALTAUSUARIENTITAT = 'AltaUsuariEntitat';
	const LOGIN = 'login';
	const LOGOUT = 'logout';
	
	public static function AfegirRegistre($Qui,$Accio,$Objecte,$Taula)
	{
		
		$Reg = new Registreactivitat();
		$Reg->setNew(true);
  		$Reg->setIdusuari($Qui);
  		$Reg->setAccio($Accio);
  		if(is_object($Objecte)) $Reg->setDades(implode('@@@',$Objecte->toArray()));
  		else  		  			$Reg->setDades(null);
  		$Reg->setTimestamp(time());
  		$Reg->setTaula($Taula);
  		$Reg->save();
  		
	}

}
