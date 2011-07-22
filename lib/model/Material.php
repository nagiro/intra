<?php

/**
 * Subclass for representing a row from the 'material' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Material extends BaseMaterial
{
    public function toString()
    {
        return $this->getIdentificador().' - '.$this->getNom();
    }
    
    public function setInactiu()
    {
        $this->setActiu(false);
        $this->save();
    }
}
