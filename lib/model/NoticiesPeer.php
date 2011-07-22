<?php

class NoticiesPeer extends BaseNoticiesPeer
{
	
    static public function getCriteriaActiu($C,$idS)
    {
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        return $C;
    }
        
  	static public function initialize( $idN , $idS )
	{	   
		$ON = NoticiesPeer::retrieveByPK($idN);            
		if(!($ON instanceof Noticies)):            			
			$ON = new Noticies();
            $ON->setDatapublicacio(date('Y-m-d',time()));
			$ON->setDatadesaparicio(date('Y-m-d',time()));
            $ON->setSiteId($idS);   
            $ON->setOrdre(1);     
            $ON->setActiu(true);        						
		endif; 
        
        return new NoticiesForm($ON,array('IDS'=>$idS));
	}
    
    static public function getNoticiesCriteria($C,$TEXT,$FILTRE_WEB, $TOTES, $IDS)
    {
		//Agafem totes les notícies de notícies i les activitats que hem posat que es publiquen com a notícies				
        $C = self::getCriteriaActiu( $C , $IDS );
						
		//Només les notícies amb el text oportú.
		if(!empty($TEXT)): 
			$C1 = $C->getNewCriterion(self::TITOLNOTICIA, "%$TEXT%", CRITERIA::LIKE);
			$C2 = $C->getNewCriterion(self::TEXTNOTICIA , "%$TEXT%" , CRITERIA::LIKE);
			$C1->addOr($C2); $C->add($C1);			
		endif;

        if(!$TOTES):
			$C->add( self::DATAPUBLICACIO  , date('Y-m-d',time()) , CRITERIA::LESS_EQUAL );
            $C->add( self::DATADESAPARICIO , date('Y-m-d',time()) , CRITERIA::GREATER_EQUAL );
		endif;
        
       	if($FILTRE_WEB && !$TOTES):
			$C->add(self::ACTIVA, true);
		endif; 				        

        if(!$TOTES):
            $C->addAscendingOrderByColumn(self::ORDRE);
            $C->addAscendingOrderByColumn(self::DATAPUBLICACIO);
        else: 
            $C->addDescendingOrderByColumn(self::DATAPUBLICACIO);
        endif;                  			        
        
        return $C;
        
    }
    
	static public function getNoticies($TEXT = "", $PAGINA = 1, $filtreWEB = false, $totes = false , $idS )
	{
		$C = new Criteria();
        $C = self::getNoticiesCriteria($C, $TEXT,$filtreWEB,$totes,$idS);
            
		$pager = new sfPropelPager('Noticies', 20);
	 	$pager->setCriteria($C);
	 	$pager->setPage($PAGINA);
	 	$pager->init();
	 	return $pager;		
	}
	
	static public function getNoticia( $idN , $idS )
	{
		$FON = self::initialize($idN,$idS);
        return $FON->getObject();		
	}
	
	
	static public function getNoticiaActivitat( $IDA , $idS )
	{	   		        						
		$OA = ActivitatsPeer::retrieveByPK($IDA);	
		$OH = ActivitatsPeer::getPrimerHorariActivitat($IDA,$idS);
		if($OH instanceof Horaris):											
			list($Y,$M,$D) = explode('-',$OH->getDia());
		else: 
			$D = date('d',time());
			$M = date('m',time());
			$Y = date('Y',time());
		endif; 
		
		$diai = mktime(0,0,0,$M,$D-10,$Y);
		$diaf = mktime(0,0,0,$M,$D,$Y);
							
        $FN = NoticiesPeer::initialize(0,$idS);
        $ON = $FN->getObject();
        
		$ON->setImatge($OA->getImatge());
		$ON->setAdjunt($OA->getPdf());
		$ON->setTitolnoticia($OA->getTmig());
		$ON->setTextnoticia($OA->getDmig());
		$ON->setActiva(false);		
		$ON->setIdactivitat($IDA);
		$ON->setDatapublicacio(date('Y-m-d',$diai));
		$ON->setDatadesaparicio(date('Y-m-d',$diaf));
		$ON->save();		
		return $ON;		         
	}	
    
    static public function setNewOrder($idN,$UP,$idS)
    {
        
        $C = new Criteria();
        $C = self::getNoticiesCriteria($C,'',false,false,$idS);
                                                        
        $LOP = self::doSelect($C);
        $i = 1; $pos_element = 0;
                
        //Primer fem una passada per identificar quin és el que volem canviar.
        $RET = array(); 
        foreach($LOP as $OP):
            if($OP->getIdnoticia() == $idN) $pos_element = $i;
            $RET[$i] = $OP;
            $OP->setOrdre($i)->save();
            $i = $i + 1;
        endforeach;
        
        if($UP){
            if(isset($RET[$pos_element-1])){
                $RET[$pos_element]->setOrdre($pos_element-1)->save();
                $RET[$pos_element-1]->setOrdre($pos_element)->save();
            }
        }else {
            if(isset($RET[$pos_element+1])){
                $RET[$pos_element]->setOrdre($pos_element+1)->save();
                $RET[$pos_element+1]->setOrdre($pos_element)->save();
            }
        }                        
                                
    }
/*    
    static public function selectOrdre($idS,$NOU = false)
    {
        $C = new Criteria();
        $C = self::getNoticiesCriteria($C,"",false,false,$idS);                
        $C->addAscendingOrderByColumn(self::ORDRE);        
    
        $LOP = self::doSelect($C);
        return myUser::selectOrdre($idS,$LOP,$NOU);
          
    }
*/    
}
