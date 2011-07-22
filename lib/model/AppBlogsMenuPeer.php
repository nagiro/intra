<?php

class AppBlogsMenuPeer extends BaseAppBlogsMenuPeer
{
    
    static public function getCriteriaActiu($C,$idS)
    {
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        return $C;
    }
        
  	static public function initialize( $menu_id , $blog_id , $idS )
	{	   
		$OO = AppBlogsMenuPeer::retrieveByPK($menu_id);            
		if(!($OO instanceof AppBlogsMenu)):            			
			$OO = new AppBlogsMenu();
			$OO->setName('Nom per defecte');
			$OO->setPageId(null);
			$OO->setOrder(0);
			$OO->setBlogId($blog_id);
            $OO->setSiteId($idS);        
            $OO->setActiu(true);        						
		endif; 
        
        return new AppBlogsMenuForm($OO,array('APP_BLOG'=>$blog_id,'IDS'=>$idS));
                
	}    
    	
	static public function getMaxOrder($father_id,$idS)
	{
		$C = new Criteria();
        $C = self::getCriteriaActiu($C,$idS);
		$C->add(self::FATHER_ID,$father_id);
		$C->addDescendingOrderBy(self::ORDER);
		$OO = self::doSelectOne($C);
		return $OO->getOrder();	
	}
	
	static public function getCerca($blog_id,$idS)
	{
		$C = new Criteria();
        $C = self::getCriteriaActiu($C,$idS);
		$C->add(self::BLOG_ID, $blog_id);
		return $C;
	}
	
	static public function getOptionsMenus( $blog_id , $menu_id , $options = true , $idS )
	{

		$C = self::getCerca( $blog_id , $idS );
			
		$REG = array();
		foreach(self::doSelect($C) as $OO):			
			$REG[$OO->getFatherId()][$OO->getId()]['NOM'] 	= $OO->__toString(); 
			$REG[$OO->getFatherId()][$OO->getId()]['ID'] 	= $OO->getId();						
		endforeach;
		
		if(empty($REG)) $REG = array(0=>array());
		
		if($options):
			$RET = '<option value="-1">Escull un menú...</option>';
			return $RET.self::getOptionsMenusRec($REG,$REG[0],"",$menu_id,$options);		
		else: 		
			return self::getOptionsMenusRec($REG,$REG[0],"",$menu_id,$options);
		endif; 
		
	}
	
	
	static public function getOptionsMenusRec($MENUS , $FILLS , $nivell , $menu_id_sel , $options )
	{ 
			
		$RET = ($options)?"":array();
							
		foreach( $FILLS as $K => $V ):																
			if($options): 
				$FILLS2 = (isset($MENUS[$K]))?$MENUS[$K]:array();				
				$SEL = ($K == $menu_id_sel)?'SELECTED':'';			
				$RET .= '<option '.$SEL.' value="'.$K.'">'.$nivell.' '.$K.'. '.$V['NOM'].'</option>';
				$RET .= self::getOptionsMenusRec($MENUS,$FILLS2,$nivell."-",$menu_id_sel,$options);
			else:
				$FILLS2 = (isset($MENUS[$K]))?$MENUS[$K]:array();
				$RET[$K]['NOM'] = $V['NOM'];										
				$RET[$K]['TREE'] = self::getOptionsMenusRec($MENUS,$FILLS2,$nivell."-",$menu_id_sel,$options); 																					
			endif;
		endforeach; 			
		
		return $RET;
	}

	
	static public function getBlogMenusArray( $blog_id , $idS )
	{
		$C = self::getCerca( $blog_id , $idS );
		
		$REG = array(0=>'BASE');
		
		foreach(self::doSelect($C) as $OO):
			$REG[$OO->getId()] = $OO->__toString(); 			
		endforeach;
		
		return $REG;
	 	
	}
	
	static public function getMenusWithoutPages( $blog_id , $idS )
	{

		$RET = array();
		$C = self::getCerca( $blog_id , $idS );
		
		foreach(self::doSelect($C) as $OO):
			$RET[$OO->getId()]['COUNT'] = (is_null($OO->getPageId()))?'0':'1';
			$RET[$OO->getId()]['NAME'] = $OO->getName();					
		endforeach;
		
		return $RET;

	}
	 
	
}