<?php

/**
 * Subclass for representing a row from the 'cicles' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Cicles extends BaseCicles
{
    
    public function getPrimerDia()
    {
        $C = new Criteria();        
        $C = CiclesPeer::getCriteriaActiu($C,$this->getSiteId());
        $C = ActivitatsPeer::getCriteriaActiu($C,$this->getSiteId());
        $C = HorarisPeer::getCriteriaActiu($C,$this->getSiteId());
        
        $C->add(CiclesPeer::CICLEID, $this->getCicleid());
        
        $C->addJoin(CiclesPeer::CICLEID, ActivitatsPeer::CICLES_CICLEID);
        $C->addJoin(ActivitatsPeer::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);
        $C->addAscendingOrderByColumn(HorarisPeer::DIA);                
                        
        $OH = HorarisPeer::doSelectOne($C);
        if($OH instanceof Horaris) return $OH->getDia('d/m/Y');
        else return "n/d";
                
    }
    
    public function getNumActivitats()
    {
        $C = new Criteria();
        $C = CiclesPeer::getCriteriaActiu($C,$this->getSiteId());
        $C = ActivitatsPeer::getCriteriaActiu($C,$this->getSiteId());
        $C = HorarisPeer::getCriteriaActiu($C,$this->getSiteId());
                 
        $C->addJoin(CiclesPeer::CICLEID, ActivitatsPeer::CICLES_CICLEID);
        $C->addJoin(ActivitatsPeer::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);
        
        $C->add(CiclesPeer::CICLEID, $this->getCicleid());
        
        $C->addAscendingOrderByColumn(HorarisPeer::DIA);
        $C->addGroupByColumn(ActivitatsPeer::ACTIVITATID);
        return HorarisPeer::doCount($C);        
    }
}
