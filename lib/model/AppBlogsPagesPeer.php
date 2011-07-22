<?php

class AppBlogsPagesPeer extends BaseAppBlogsPagesPeer
{
	
	const PAGE_TYPE_BLOG = 'B';
	const PAGE_TYPE_PAGE = 'P';


    static public function getCriteriaActiu( $C , $idS )
    {
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        return $C;
    }
        
  	static public function initialize( $page_id , $blog_id , $idS )
	{	   
		$OO = AppBlogsPagesPeer::retrieveByPK($page_id);            
		if(!($OO instanceof AppBlogsPages)):            			
			$OO = new AppBlogsPages();
			$OO->setName('Nom per defecte');
			$OO->setVisible(1);			
			$OO->setType(self::PAGE_TYPE_BLOG);
			$OO->setDate(date('Y-m-d',time()));            
			$OO->setBlogId($blog_id);						
            $OO->setSiteId($idS);        
            $OO->setActiu(true);        						
		endif; 
        
        return new AppBlogsPagesForm($OO,array('IDS'=>$idS));
                
	}    
	
	static public function getTypesArray(){		
		return array(self::PAGE_TYPE_BLOG=>'Blog',self::PAGE_TYPE_PAGE=>'Pàgina');
	}
	
    	
	static public function getOptionsPages( $blog_id , $menu_id = null , $page_id = null , $idS )
	{

        if($menu_id > 0)    $C = self::getCerca( $blog_id , $menu_id , $idS );
        else                $C = self::getCerca( $blog_id , null , $idS );
         				
		$Q = self::doSelect($C);				
		$RET = '<option value="-1">('.sizeof($Q).') Escull una pàgina...</option>';
		foreach($Q as $OO):
			$SEL = ($OO->getId() == $page_id)?'SELECTED':'';
			$RET .= '<option '.$SEL.' value="'.$OO->getId().'">'.$OO->__toString().'</option>';			
		endforeach;
		
		return $RET;		
		
	}
	
	static public function getBlogPagesArray( $blog_id , $idS )
	{
		
		$C = self::getCerca( $blog_id , null , $idS );
		
		$REG = array(null=>'Cap pàgina');
		
		foreach(self::doSelect($C) as $OO):
			$REG[$OO->getId()] = $OO->__toString(); 			
		endforeach;
		
		return $REG;
	 	
	}
	
	static public function getCerca( $blog_id = null , $menu_id = null , $idS )
	{
		$C = new Criteria();
        $C = self::getCriteriaActiu($C,$idS);
		
		if(!is_null($blog_id)): 			
			$C->add(self::BLOG_ID, $blog_id); 
		endif; 
		
		if(!is_null($menu_id) && $menu_id > 0): 			
			$C->addJoin(self::ID, AppBlogsMenuPeer::PAGE_ID);
			$C->add(AppBlogsMenuPeer::ID , $menu_id); 
		endif; 
		
		return $C;
	}
	
	static public function getPagesWithoutContent($blog_id,$idS)
	{

		$RET = array();
		$C = self::getCerca($blog_id,null,$idS);
		
		foreach(self::doSelect($C) as $OO):
			$RET[$OO->getId()]['COUNT'] = $OO->countAppBlogsEntriess();
			$RET[$OO->getId()]['NAME']  = $OO->getName();					
		endforeach;
		
		return $RET;

	}
	
    static public function getPagesSelect( $blog_id , $idS )
    {
        $C = new Criteria();
        $C = AppBlogsPagesPeer::getCriteriaActiu($C,$idS);
        $C->add(AppBlogsPagesPeer::BLOG_ID , $blog_id);
        
        $RET = array();
        foreach(AppBlogsPagesPeer::doSelect($C) as $P):
            $RET[$P->getId()] = $P->getName();
        endforeach;
        
        return $RET;
    }
    
}
