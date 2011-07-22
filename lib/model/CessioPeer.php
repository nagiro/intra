<?php

class CessioPeer extends BaseCessioPeer
{

   static public function getCriteriaActiu($C,$idS)
   {
    $C->add(self::ACTIU, true);
    $C->add(self::SITE_ID, $idS);
    return $C;
   }

  static function inicialitza( $id , $idS , $retorn = false )
  {
  	
  	$OC = self::retrieveByPK($id);
    
  	if($OC instanceof Cessio):
        if($retorn):            
            $OC->setEstatRetornat("");
    		$OC->setDataretornat(date('Y-m-d',time()));
            return new CessiomaterialRetornForm($OC,array('IDS'=>$idS));
        else:
            return new CessioForm($OC,array('IDS'=>$idS));
        endif;
  	else:
  		$OC = new Cessio();
        $OC->setRetornat(false);
        $OC->setUsuariId(null);
		$OC->setEstatRetornat("");
		$OC->setDataretornat(null);
		$OC->setDatacessio(date('m/d/Y',time()));
		$OC->setDataretorn(date('m/d/Y',time()));
		$OC->setMotiu( OptionsPeer::getString('CESSIO_TEXT_MOTIU', $idS ) );
		$OC->setCondicions( OptionsPeer::getString('CESSIO_TEXT_CONDICIONS' , $idS ) );    			    			    	    			          		  		
        $OC->setSiteId($idS);     
        $OC->setActiu(true);		
        if($retorn):
            $OC->setRetornat(true);
            $OC->setEstatRetornat("");
    		$OC->setDataretornat(date('Y-m-d',time()));
            return new CessiomaterialRetornForm($OC,array('IDS'=>$idS));
        else:
            return new CessioForm($OC,array('IDS'=>$idS));
        endif;  		
  	endif;
  	  	
  }

	
   static public function getCessions($PAGINA,$cedit,$text,$idS)
   {
    $C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    $C->add(CessioPeer::RETORNAT,!$cedit);
    $C->addDescendingOrderByColumn(CessioPeer::RETORNAT);
    $C->addDescendingOrderByColumn(CessioPeer::DATA_RETORN);
          
    $pager = new sfPropelPager('Cessio', 10);
	$pager->setCriteria($C);
	$pager->setPage($PAGINA);
	$pager->init();  	
  	return $pager;
   }
   
   static public function printDocument($OCESSIO)
   {
     	  
   	  $OCM = $OCESSIO->getCessiomaterials();   	  

   	  $MAT = "";
	  foreach($OCM as $OCMAT):
	  	$OMAT = $OCMAT->getMaterial();	  	
	  	$MAT .= ' un/a '.$OMAT->getNom().' amb identificador '.$OMAT->getIdentificador().',';	  		  		  
	  endforeach;
   	  
	  // create the document
	  $doc = new sfTinyDoc();
	  $doc->createFrom(array('extension' => 'docx'));
	  $doc->loadXml('word/document.xml');

	  $doc->mergeXmlField('NOM',$OCESSIO->getNom());
	  $doc->mergeXmlField('DNI',$OCESSIO->getDni());
	  $doc->mergeXmlField('REPRESENTANT',$OCESSIO->getRepresentant());	  
	  $doc->mergeXmlField('MATERIAL',$MAT);	  
	  if($OCESSIO->getMaterialNoInventariat() != '') 
	  	$doc->mergeXmlField('MATERIAL_NO_INVENTARIAT',' i '.$OCESSIO->getMaterialNoInventariat());	  	  
      else $doc->mergeXmlField('MATERIAL_NO_INVENTARIAT','');
	  $doc->mergeXmlField('MOTIU',$OCESSIO->getMotiu());	  	  
	  $doc->mergeXmlField('CONDICIONS1',$OCESSIO->getCondicions());
	  $doc->mergeXmlField('DATA_SORTIDA',$OCESSIO->getDataCessio());
	  $doc->mergeXmlField('DATA_RETORN',$OCESSIO->getDataRetorn());
	  	  	  
	  $doc->saveXml();
	  $doc->close();
	 
	  // send and remove the document
	  $doc->sendResponse();
	  $doc->remove();
	 
	  throw new sfStopException;
   	
   }
   
}
