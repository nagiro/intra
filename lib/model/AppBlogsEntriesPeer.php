<?php

class AppBlogsEntriesPeer extends BaseAppBlogsEntriesPeer
{
    
    static public function getCriteriaActiu( $C , $idS )
    {
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        return $C;
    }
        
  	static public function initialize( $entry_id , $lang = 'CA' , $page_id , $blog_id ,  $idS )
	{	   
		$OO = AppBlogsEntriesPeer::retrieveByPK($entry_id);            
		if(!($OO instanceof AppBlogsEntries)):            			
			$OO = new AppBlogsEntries();			
			$OO->setTitle('Títol per defecte');
			$OO->setBody("Cos per defecte");
			$OO->setLang($lang);
			$OO->setPageId($page_id);			
			$OO->setDate(date('Y-m-d H:i:s',time()));			
            $OO->setSiteId($idS);        
            $OO->setActiu(true);        						
		endif; 
        
        return new AppBlogsEntriesForm($OO,array( 'IDS'=>$idS , 'APP_BLOG'=>$blog_id ));
                
	}        
    	
	static public function cerca( $page_id , $idS )
	{
		$C = new Criteria();
        $C = self::getCriteriaActiu( $C , $idS );
		if($page_id > 0) $C->add(self::PAGE_ID, $page_id);
		$C->add(self::LANG, 'CA');
		
		return $C;
	}
	
	static public function getOptionsEntries( $page_id = 0 , $entry_id , $idS )
	{
		
		$C = self::cerca( $page_id , $idS );
		$Q = self::doSelect($C);		
		$RET = '<option value="-1">('.sizeof($Q).') Escull una entrada...</option>';
		
		foreach(self::doSelect($C) as $OO):
        			
            $SEL = ($OO->getId() == $entry_id)?'SELECTED':'';                        
            $RET .= '<option '.$SEL.' value="'.$OO->getId().'">'.$OO->getDate('d/m/Y').' - '.$OO->getTitle().'</option>';
            
		endforeach;
		
		return $RET;		
		
	}
	
	static public function getFiles( $entry_id , $idS )
	{
		$C = new Criteria();
		$C->addJoin(self::ID,AppBlogMultimediaEntriesPeer::ENTRIES_ID);
		$C->addJoin(AppBlogMultimediaEntriesPeer::MULTIMEDIA_ID,AppBlogsMultimediaPeer::ID);		
		$C->add(self::ID, $entry_id);
		
		return AppBlogsMultimediaPeer::doSelect($C);
	}
    	
	static public function getEntries($page_id = null,$PAGINA = 1, $AscOrder = true , $idS )
	{
		$C = new Criteria();
        $C = self::getCriteriaActiu( $C , $idS );		
		if(!is_null($page_id)) $C->add(self::PAGE_ID,$page_id);
		
		if($AscOrder) $C->addAscendingOrderByColumn(self::DATE);
		else $C->addDescendingOrderByColumn(self::DATE);
		
		$pager = new sfPropelPager('AppBlogsEntries', 6);
	 	$pager->setCriteria($C);
	 	$pager->setPage($PAGINA);
	 	$pager->init();
	 	return $pager;
		
	}
	
}