<?php

class AppDocumentsDirectorisPeer extends BaseAppDocumentsDirectorisPeer
{
    
    static public function getCriteriaActiu($C,$idS)
    {
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        return $C;
    }
        
  	static public function initialize( $idD , $idS )
	{	   
		$O = AppDocumentsDirectorisPeer::retrieveByPK( $idD );            
		if(!($O instanceof AppDocumentsDirectoris)):            			
			$O = new AppDocumentsDirectoris();                                    
            $O->setSiteId($idS);        
            $O->setActiu(true);        						
		endif; 
        
        return new AppDocumentsDirectorisForm($O,array('IDS'=>$idS));
	}
    
    
	static public function getDirectoris( $IDU = null , $idS )
	{
		$RET = array();
		$C = new Criteria();		
        $C = self::getCriteriaActiu( $C , $idS );
        $C = AppDocumentsPermisosDirPeer::getCriteriaActiu( $C , $idS );
        
		if(!is_null($IDU)):
			$C->add(AppDocumentsPermisosDirPeer::IDUSUARI, $IDU);
			$C->addJoin(AppDocumentsPermisosDirPeer::IDDIRECTORI,self::IDDIRECTORI);
		endif; 
		
        foreach(self::doSelect($C) as $DIR):
			$RET[$DIR->getPare()][$DIR->getIddirectori()] = $DIR->getNom() ;			
		endforeach;                
						
		return $RET;
	}
	
	
	static public function getSelectDirectoris($idS)
	{
	
		$RET = array();
		$DIRS = self::getDirectoris( null , $idS );		
		return self::getRecursiveDirs($DIRS , 0 , 'BASE' , $idS );
				
	}
		
	
	static public function getRecursiveDirs( $DIRECTORIS , $DIR_PARE , $NOM_PARE , $idS )
	{		
		$RET = array($DIR_PARE=>$NOM_PARE);

		if(isset($DIRECTORIS[$DIR_PARE])):
			foreach($DIRECTORIS[$DIR_PARE] as $DIR_FILL => $NOM_FILL):
				$NOM = $NOM_PARE.'/'.$NOM_FILL;							
				$RET = $RET + self::getRecursiveDirs($DIRECTORIS , $DIR_FILL , $NOM , $idS ); 							
			endforeach;
		endif; 
											
		return $RET;		
	} 
		
	static public function existDir( $nomDir , $pare , $idS )
	{
		$C = new Criteria();
        $C = self::getCriteriaActiu($C,$idS);
        $C->add(self::NOM,$nomDir);
		$C->add(self::PARE,$pare);
		return (self::doCount($C) > 0);		
	}
	
}
