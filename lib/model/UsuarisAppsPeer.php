<?php

class UsuarisAppsPeer extends BaseUsuarisAppsPeer
{
	
    static public function getCriteriaActiu($C,$idS)
    {
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        return $C;
    }
        
  	static public function initialize( $IDA , $IDU , $idS )
	{	   
		$OA = self::retrieveByPK($IDU,$IDA);            
		if(!($OA instanceof UsuarisApps)):            			
			$OA = new UsuarisApps();            
            $OA->setSiteId($idS);        
            $OA->setActiu(true);        						
		endif; 
        
        return new UsuarisAppsForm($OA,array('IDS'=>$idS));
	}
	
	
	//Retorna una llista amb les aplicacions on hi té permís. 
	static public function getPermisos( $IDU , $idS )
	{
		
		$RET = array();
		$C = new Criteria();
        $C = UsuarisPeer::getCriteriaActiu($C,$idS);
        
		$C->add(self::USUARI_ID, $IDU);

		foreach(self::doSelect($C) as $APP):			
			$RET[$APP->getAppId()] = $APP->getNivellId();					
		endforeach;		
		
		return $RET; 
				
	}
	
	static public function getPermisosOO( $IDU , $IDS )
	{				
		$C = new Criteria();
        $C = self::getCriteriaActiu($C,$IDS);
        $C = AppsPeer::getCriteriaActiu($C,$IDS);
        
		$C->add(self::USUARI_ID, $IDU);
		$C->add(self::NIVELL_ID, NivellsPeer::CAP, CRITERIA::NOT_EQUAL);
		$C->addJoin(self::APP_ID, AppsPeer::APP_ID);
		
		return AppsPeer::doSelect($C);						 				
	}
	
	
	static public function save( $PERMISOS , $IDU , $IDS )
	{		
		foreach($PERMISOS as $IDAPP => $PERM):
			$OAPP = self::retrieveByPK( $IDU , $IDAPP );
			if( $OAPP instanceof UsuarisApps ):
				$OAPP->setNivellId($PERM);
			else: 
                $OAPP = self::initialize($IDAPP,$IDU,$IDS)->getObject();				
				$OAPP->setAppId($IDAPP);
				$OAPP->setUsuariId($IDU);
				$OAPP->setNivellId($PERM);                				
			endif; 
			
			$OAPP->save();
			
		endforeach;
	}
	
	//Retorna la select amb les usuaris que poden entrar a l'aplicació
	static public function getSelectUsuarisPermis( $APPID , $idS )
	{
		
		$RET = array();        
		
		$C = new Criteria();
        $C = self::getCriteriaActiu($C,$idS);
        $C = UsuarisPeer::getCriteriaActiu($C,$idS);
        		
		$C->addJoin(UsuarisPeer::USUARIID,self::USUARI_ID);
						
		foreach(UsuarisPeer::doSelect($C) as $U):
			$RET[$U->getUsuariid()] = $U->getDni().' - '.$U->getNomComplet();  			  		
  		endforeach;
		
  		return $RET;
		
	}
	
}