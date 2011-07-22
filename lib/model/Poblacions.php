<?php

/**
 * Subclass for representing a row from the 'poblacions' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Poblacions extends BasePoblacions
{
	public function __toString()
	{
		return $this->getNom();
	}

}
