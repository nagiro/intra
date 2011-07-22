<?php

/**
 * Subclass for representing a row from the 'agendatelefonicadades' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Agendatelefonicadades extends BaseAgendatelefonicadades
{
	public function getTipusString()
	{
		return AgendatelefonicadadesPeer::getTipus($this->tipus);		
	}

    public function setInactiu()
    {
        $this->setActiu(false);    
        $this->save();
    }

}
