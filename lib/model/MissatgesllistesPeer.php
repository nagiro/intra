<?php

/**
 * Subclass for performing query and update operations on the 'missatgesllistes' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MissatgesllistesPeer extends BaseMissatgesllistesPeer
{
    
    static public function getCriteriaActiu($C,$idS)
    {
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        return $C;
    }
        
  	static public function initialize( $ID , $IDL , $idS )
	{	   
		$O = self::retrieveByPK($ID,$IDL);            
		if(!($O instanceof Missatgesllistes)):            			
			$O = new Missatgesllistes();
            $O->setIdmissatgesllistes($ID);
 		    $O->setLlistesIdllistes($IDL);
	    	$O->setEnviat(null);		
            $O->setSiteId($idS);        
            $O->setActiu(true);        						
		endif; 
        
        return new MissatgesllistesForm($O,array('IDS'=>$idS));
	}    
    
    
	//Recollim les llistes a les que s'ha vinculat el missatge
	static public function getLlistesArray($IDM,$idS)
	{
		$RET = array();
				
		$C = new Criteria();
        $C = self::getCriteriaActiu($C,$idS);
        $C = LlistesPeer::getCriteriaActiu($C,$idS);
        
		$C->add(self::IDMISSATGESLLISTES,$IDM);
        $C->addJoin(self::LLISTES_IDLLISTES, LlistesPeer::IDLLISTES);		
		
        foreach(LlistesPeer::doSelect($C) as $OL) { $RET[] = $OL->getIdllistes(); }
		                
		return $RET;
		
	}
	
}
