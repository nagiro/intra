<?php

/**
 * Subclass for representing a row from the 'horaris' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Horaris extends BaseHoraris
{

    public function setInactiu()
    {
        $this->setActiu(false);
        $C = new Criteria();
        $C = HorarisespaisPeer::getCriteriaActiu($C,$this->getSiteid());
        
        foreach($this->getHorarisespaiss($C) as $OHE):            
            $OHE->setInactiu();
        endforeach;        
        
        $this->save();                
    }
	
	public function getMaterials()
	{
		$RET = array();
		foreach($this->getHorarisespaissJoinMaterial() as $HE):		
			$M = $HE->getMaterial();
			if($M instanceof Materials)	$RET[] = $M;			
		endforeach;
		return $RET;
	}
	
	public function getArrayEspais()
	{
		$RET = array();		
		foreach($this->getHorarisespaiss() as $HE):																									
			$RET[] = $HE->getEspais();									
		endforeach;		
		return $RET;
	}
    
    //Funció usada a gActivitats per llistar els espais
    public function getArrayHorarisEspaisActiusAgrupats()
    {
        $RET = array();
        $C = new Criteria();
        $C = HorarisespaisPeer::getCriteriaActiu($C,$this->getSiteId());        
        //Seleccionem els horaris interns només    
//        $C->add( HorarisespaisPeer::IDESPAIEXTERN, null );
        $C->addGroupByColumn( HorarisespaisPeer::ESPAIS_ESPAIID );        
        $LHE = $this->getHorarisespaiss($C);     
        //Ho posem en format que quedi igual que després de l'HTML                   
        foreach($LHE as $HE):                                                
            $RET[$HE->getEspaisEspaiid()] = $HE->getNomEspai();
        endforeach;        
        return $RET;                
    }
    
    public function getArrayHorarisEspaisMaterial()
    {
        $RET = array();
        $C = new Criteria();
        $C = HorarisespaisPeer::getCriteriaActiu($C,$this->getSiteId());            
  //      $C->add( HorarisespaisPeer::IDESPAIEXTERN, null);
        $C->addGroupByColumn( HorarisespaisPeer::MATERIAL_IDMATERIAL );        
        $LHE = $this->getHorarisespaiss($C);                
        foreach($LHE as $HE):
            $OM = MaterialPeer::retrieveByPK($HE->getMaterialIdmaterial());
            if($OM instanceof Material):
                $RET[$OM->getIdmaterial()] = array('material'=>$OM->getIdmaterial(),'nom'=>$OM->toString(),'generic'=>$OM->getMaterialgenericIdmaterialgeneric());
            endif;
        endforeach;        
        return $RET;        
    } 

    public function hasEspaiExtern()
    {
        $LEE = EspaisExternsPeer::criteriaHorari_EspaiExtern( $this->getHorarisid() , new Criteria() , $this->getSiteId() );        
        if(sizeof($LEE)>0) return true;
        else return false;                 
    }

    public function getEspaiExternForm()
    {        
        if($this->hasEspaiExtern()){            
            $LEE = EspaisExternsPeer::criteriaHorari_EspaiExtern( $this->getHorarisid() , new Criteria() , $this->getSiteId() );
            return EspaisExternsPeer::initialize($LEE[0]->getIdespaiextern());
        }  
        else{
            return EspaisExternsPeer::initialize(null);
        }
    }

    public function getActivitatss()
    {
        $C = new Criteria();                        
        $C = ActivitatsPeer::getCriteriaActiu($C,$this->getSiteId());
        $C = HorarisPeer::getCriteriaActiu($C,$this->getSiteId());
        
        $C->add(HorarisPeer::HORARISID, $this->getHorarisid());
        $C->addJoin(HorarisPeer::ACTIVITATS_ACTIVITATID, ActivitatsPeer::ACTIVITATID);
        $C->addGroupByColumn(ActivitatsPeer::ACTIVITATID);
        
        return ActivitatsPeer::doSelectOne($C);        
    }
    
    public function getPoblacioString()
    {
        $OP = PoblacionsPeer::retrieveByPK($this->getPoblacio());
        if($OP instanceof Poblacions) return $OP->getNom();
        else return "n/d";        
    }
   
}
