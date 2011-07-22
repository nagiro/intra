<?php

/**
 * Subclass for representing a row from the 'nivells' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Nivells extends BaseNivells
{
	const ADMIN = 1;
	const USER = 2;
	const RUSER = 3; //Restricted user ( nom�s pot accedir a lo seu )
	
	public function __toString()
	{
		return $this->getNom();	
	}
}
