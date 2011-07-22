<?php

class AppBlogsBlogsPeer extends BaseAppBlogsBlogsPeer
{
	
    static public function getCriteriaActiu($C,$idS)
    {
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        return $C;
    }
        
  	static public function initialize( $id , $idS )
	{	   
	   
		$OO = AppBlogsBlogsPeer::retrieveByPK( $id );            
		if(!($OO instanceof AppBlogsBlogs)):            			
			$OO = new AppBlogsBlogs();
			$OO->setName('Nom per defecte');
			$OO->setDate(date('Y-m-d',time()));		            
            $OO->setSiteId($idS);        
            $OO->setActiu(true);        						
		endif; 
        
        return new AppBlogsBlogsForm($OO,array('IDS'=>$idS));
                
	}        
	
	static public function getOptionsBlogs( $APP_BLOG_ID , $idS )
	{		
	
        $C = new Criteria();
        $C = self::getCriteriaActiu($C,$idS);
    		
		$RET = '<option value="-1">Escull un blog...</option>';
		foreach(self::doSelect($C) as $OO):
			$SEL = ($OO->getId() == $APP_BLOG_ID)?'SELECTED':'';
			$RET .= '<option '.$SEL.' value="'.$OO->getId().'">'.$OO->getId().'. '.$OO->getName().'</option>';			
		endforeach;
		
		return $RET;		
		
	}
			
}