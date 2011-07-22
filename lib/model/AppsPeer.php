<?php

class AppsPeer extends BaseAppsPeer
{

    const APP_DOCUMENTS = 3;
    
    static public function getCriteriaActiu($C,$idS)
    {
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        return $C;
    }
        
  	static public function initialize( $idA , $idS )
	{	   
		$OA = AppsPeer::retrieveByPK($idA);            
		if(!($OA instanceof Apps)):            			
			$OA = new Apps();
            $OA->setSiteId($idS);        
            $OA->setActiu(true);        						
		endif; 
        
        return new AppsForm($ON,array('IDS'=>$idS));
	}
    
    
	static public function select()
	{
		$C = new Criteria();
		$RET = array();
		
		foreach(self::doSelect($C) as $APP):
			$RET[$APP->getAppId()] = $APP->getNom();  									
		endforeach;
		
		return $RET;
	}
	
	static public function getNom($IDAPP)
	{
		$OAPP = self::retrieveByPK($IDAPP);		
		if( $OAPP instanceof Apps ):
			return $OAPP->getNom();
		else:
			return 'n/d';
		endif; 
	}

	
}
