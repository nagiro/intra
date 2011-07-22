<?php

/**
 * Subclass for representing a row from the 'agendatelefonica' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Agendatelefonica extends BaseAgendatelefonica
{
    
    public function getAgendatelefonicadadesActiu()
    {
        $C = new Criteria();
        $C = AgendatelefonicadadesPeer::getCriteriaActiu($C,$this->getSiteId());
        return $this->getAgendatelefonicadadess($C);        
    }
    
    public function setInactiu()
    {
        $this->setActiu(false);
        foreach($this->getAgendatelefonicadadesActiu() as $ATD):
            $ATD->setInactiu();
        endforeach;
        $this->save();
    }
            
}
