<?php

class MissatgesmailingPeer extends BaseMissatgesmailingPeer
{
    
    static public function getCriteriaActiu($C,$idS)
    {
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        return $C;
    }
        
  	static public function initialize( $ID , $idS )
	{	   
		$O = self::retrieveByPK($ID);            
		if(!($O instanceof Missatgesmailing)):            			
			$O = new Missatgesmailing();
            $O->setDataAlta(date('Y-m-d',time()));
            $O->setText(MissatgesmailingPeer::getTemplate($idS));                        
            $O->setSiteId($idS);        
            $O->setActiu(true);                    						
		endif; 
        
        return new MissatgesmailingForm($O,array('IDS'=>$idS));
	}    
    
    static public function getTemplate($idS)
    {            
        $TEXT = OptionsPeer::getString('MAILING_TEMPLATE',$idS);                
        return $TEXT;
    }
    
	static public function getMissatges( $idL = 0 , $pagina = 1 , $idS )
	{
		
		$C = new Criteria();
        $C = self::getCriteriaActiu($C,$idS);
        $C = MissatgesLlistesPeer::getCriteriaActiu($C,$idS);
        
        if( $idL > 0 ):
            $C->addJoin(self::IDMISSATGE,MissatgesLlistesPeer::IDMISSATGESLLISTES);
            $C->add(MissatgesllistesPeer::LLISTES_IDLLISTES, $idL);
        endif; 
		$C->addDescendingOrderByColumn(self::IDMISSATGE);
		
		$pager = new sfPropelPager('Missatgesmailing', 20);
	    $pager->setCriteria($C);
	    $pager->setPage($pagina);
	    $pager->init();
	    return $pager;
		
	}
				                
}
