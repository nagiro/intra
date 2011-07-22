<?php

/**
 * Subclass for performing query and update operations on the 'cessiomaterial' table.
 *
 * 
 *
 * @package lib.model
 */ 
class CessiomaterialPeer extends BaseCessiomaterialPeer
{
    
    
   static public function getCriteriaActiu($C,$idS)
   {
    $C->add(self::ACTIU, true);
    $C->add(self::SITE_ID, $idS);
    return $C;
   }

    
   /**
    * 
    * @param Cessiomaterial $OCESSIO
    * @return array('HORARIS','CESSIONS')
    */
   static public function isDisponible(CessiomaterialForm $OCESSIO)
   {
   		//Mirem si l'article que volem cedir, està disponible a la data de cessio i fins data de retorn (dins els cedits).   		
   		//Mirem que no s'utilitzi a cap esdeveniment  
   	
   		//com saber si un període està pel mig d'un altre. Di1 = HORARIS.DIA
   		//   DrI DrF
   		//     DpI DpF
   		 	   	
   		$ret = array();
   		$dC  = $OCESSIO->getValue('DataCessio');
   		$dR  = $OCESSIO->getValue('DataRetorn');
   		$idM = $OCESSIO->getValue('Material_idMaterial');
   		$idC = $OCESSIO->getValue('idCessioMaterial');
   		   	
   		//Si un dia d'horaris encaixa pel mig del període de cessió, és dolent. 
   		$C = new Criteria();
   		$C1 = $C->getNewCriterion(HorarisPeer::DIA,$dC,CRITERIA::GREATER_EQUAL);
   		$C2 = $C->getNewCriterion(HorarisPeer::DIA,$dR,CRITERIA::LESS_EQUAL);
   		$C1->addAnd($C2);
   		$C->addOr($C1);
   		$C->addJoin(HorarisPeer::HORARISID, HorarisespaisPeer::HORARIS_HORARISID);
   		$C->add(HorarisespaisPeer::MATERIAL_IDMATERIAL,$idM);   		
   		
   		$ret['HORARIS'] = HorarisPeer::doSelect($C);
   		
   		//Mirem que no l'haguem cedit algun dia d'aquests
   		$C = new Criteria();
   		$C3 = $C->getNewCriterion( self::DATACESSIO , $dC , CRITERIA::GREATER_EQUAL );
   		$C4 = $C->getNewCriterion( self::DATACESSIO , $dR , CRITERIA::LESS_EQUAL );
   		$C3->addAnd( $C4 );
   		
   		$C5 = $C->getNewCriterion( self::DATARETORN , $dR , CRITERIA::LESS_EQUAL );
   		$C6 = $C->getNewCriterion( self::DATARETORN , $dC , CRITERIA::GREATER_EQUAL );
   		$C5->addAnd( $C6 );
   		
   		$C7 = $C->getNewCriterion( self::DATACESSIO , $dC , CRITERIA::GREATER_EQUAL );
   		$C8 = $C->getNewCriterion( self::DATARETORN , $dR , CRITERIA::LESS_EQUAL );
   		$C7->addAnd( $C8 );
   		   		
   		$C3->addOr($C5); $C3->addOr($C7); $C->add($C3);
   		$C->add( self::MATERIAL_IDMATERIAL , $idM , CRITERIA::EQUAL );
   		$C->add( self::IDCESSIOMATERIAL , $idC , CRITERIA::NOT_EQUAL);
   		$C->add( self::RETORNAT , false );
   		
   		$ret['CESSIONS'] = self::doSelect($C);
   		   		   		
   		return $ret; 
   		   		   	   		
   }
   
   static public function update($RMATERIAL , $FCessio , $idS)
   {
    
    $MERGE = array();
    $OC = $FCessio->getObject();
    $idC = $OC->getCessioId();
    $ERROR = array();
    
    $C = new Criteria();
    $C->add( self::SITE_ID , $idS );
    $C->add( self::CESSIO_ID , $idC );
    $C->add( self::ACTIU , true );    
    
    foreach($RMATERIAL as $D=>$idM):
        if(!MaterialPeer::isLliureFranja($idM,$idS,$OC->getDatacessio(),$OC->getDataRetorn(),'00:00','24:00',null,$idC)):
            $OM = MaterialPeer::retrieveByPK($idM);    
            $ERROR[$idM] = $OM->toString(); 
        endif; 
    endforeach;
    
    if(empty($ERROR)): 

        foreach(self::doSelect($C) as $V):
            $V->setActiu(false);
            $V->save();
            $MERGE[$V->getIdcessiomaterial()] = $V;            
        endforeach;
    
        foreach($RMATERIAL as $D => $idM):    		    	
                    
            if(isset($MERGE[$idM])):
                $MERGE[$idM]->setActiu(true);
                $MERGE[$idM]->save();            
            else:
              	$OMC = new Cessiomaterial();
                $OMC->setMaterialIdmaterial($idM);
        		$OMC->setCessioId($idC);
                $OMC->setSiteId($idS);
                $OMC->setActiu(true);
        		$OMC->save();    		
            endif;
                		       		      		     		    
        endforeach;                         
    endif;
    
    return $ERROR;                
        		              
   }
   
   static public function getSelectMaterialOut( $idC , $idS )
   {
	   	$C = new Criteria();
        
	   	$C->add(self::CESSIO_ID, $idC);
        $C->add(self::SITE_ID , $idS );
        $C->add(self::ACTIU , true );
	   	$C->addJoin(self::MATERIAL_IDMATERIAL,MaterialPeer::IDMATERIAL);
	   	
        $RET = array();
	   	
	   	foreach(MaterialPeer::doSelect($C) as $K=>$V):
			$RET[] = array('material'=>$V->getIdmaterial(), 'generic'=>$V->getMaterialgenericIdmaterialgeneric());
	   	endforeach;
	   	
	   	return $RET;
   }
   
   
  static function getCeditAAjax($query,$limit)
  {
  	$RET = array();
  	$C = new Criteria();
  	$C->add(self::CEDITA, "%".$query."%",CRITERIA::LIKE);
    $C->addAscendingOrderByColumn(self::CEDITA);
    $C->setLimit($limit);
	
    $RET[$query] = array('clau'=>$query,'text'=>$query);  	     	
  	foreach(self::doSelect($C) as $CEDIT):
  		$RET[$CEDIT->getCedita()] = array('clau'=>$CEDIT->getCedita(),'text'=>$CEDIT->getCedita());  		
  	endforeach;
  	
  	return $RET;
  	
  }   
       
}