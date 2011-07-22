<?php

class AppDocumentsPermisosDirPeer extends BaseAppDocumentsPermisosDirPeer
{
    
    static public function getCriteriaActiu($C,$idS)
    {
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        return $C;
    }
        
  	static public function initialize( $idU , $idD , $idS , $idN = NivellsPeer::CAP )
	{	   
		$O = AppDocumentsPermisosDirPeer::retrieveByPK( $idU , $idD );            
		if(!($O instanceof AppDocumentsPermisosDir)):            			
			$O = new AppDocumentsPermisosDir();
            $O->setidusuari($idU);
            $O->setIddirectori($idD);
            $O->setIdnivell($idN);                                    
            $O->setSiteId($idS);        
            $O->setActiu(true);        						
		endif; 
        
        return new AppDocumentsPermisosDirForm($O,array('app'=>AppsPeer::APP_DOCUMENTS,'IDS'=>$idS));
	}
    
    
	static public function getLlistatPermisos( $IDD , $idS )
	{
		$RET = array();
		
		$C = new Criteria();
        $C = self::getCriteriaActiu( $C , $idS );
		$C->add(self::IDDIRECTORI,$IDD);
		
		foreach(self::doSelect($C) as $PERM_DIR):
			$RET[] = array(
							'idUsuari'  => $PERM_DIR->getIdusuari(),
							'idNivell'  => $PERM_DIR->getIdnivell(),
							'DNI' 		=> $PERM_DIR->getUsuaris()->getDni(),
							'nomUsuari' => $PERM_DIR->getUsuaris()->getNomComplet(),
							'nomNivell' => $PERM_DIR->getNivells()->getNom(), 
			
			); 						
		
		endforeach;

		return $RET;
	}
	
	static public function getPermis( $IDU , $IDD , $IDS )
	{
		$C = new Criteria();
        $C = self::getCriteriaActiu( $C , $IDS );
		$C->add(self::IDUSUARI,$IDU);
		$C->add(self::IDDIRECTORI,$IDD);
		
		$PERMIS = self::doSelectOne($C);
		if($PERMIS instanceof AppDocumentsPermisosDir):
			return $PERMIS->getIdnivell();
		else: 
			return NivellsPeer::CAP; 
		endif;  
						
	}

    static public function addUser($idU,$idD,$idS,$idN = NivellsPeer::EDICIO)
    {        
        $O = self::initialize( $idU , $idD , $idS , $idN )->getObject();
        try{
          $O->setIdusuari($idU);
          $O->setIddirectori($idD);
          $O->setIdnivell($idN);
          $O->save(); 
          } catch (Exception $e) { return false; }
        return true;                
    }
		
}
