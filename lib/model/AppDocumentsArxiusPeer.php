<?php

class AppDocumentsArxiusPeer extends BaseAppDocumentsArxiusPeer
{	
    
    static public function getCriteriaActiu($C,$idS)
    {
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        return $C;
    }
        
  	static public function initialize( $id , $IDD , $idS )
	{	   
	   
		$OO = self::retrieveByPK( $id );            
		if(!($OO instanceof AppDocumentsArxius)):            			
			$OO = new AppDocumentsArxius();
			$OO->setName('Nom per defecte');
            $OO->setUrl('#');
			$OO->setDataCreacio(date('Y-m-d',time()));
            $OO->setIddirectori($IDD);            		            
            $OO->setSiteId($idS);        
            $OO->setActiu(true);        						
		endif; 
        
        return new AppDocumentsArxiusForm($OO,array('IDS'=>$idS));
                
	}        
    
}
