<?php

/**
 * Subclass for representing a row from the 'materialgeneric' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Materialgeneric extends BaseMaterialgeneric
{
    public function setInactiu()    
    {
        $this->setActiu(false);
        foreach($this->getMaterialsActiu() as $OM):
            $OM->setInactiu();
        endforeach;
        $this->save();
    }

    public function getMaterialsActiu()
    {
        $C = new Criteria();
        $C = MaterialPeer::getCriteriaActiu($C,$this->getSiteId());
        return $this->getMaterials($C);
    }

}