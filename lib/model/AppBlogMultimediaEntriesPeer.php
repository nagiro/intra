<?php

class AppBlogMultimediaEntriesPeer extends BaseAppBlogMultimediaEntriesPeer
{
    
    static public function getCriteriaActiu($C,$idS)
    {
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        return $C;
    }
        
  	static public function initialize( $idEntry , $idMultimedia , $idS )
	{	   
		$OO = AppBlogMultimediaEntriesPeer::retrieveByPK( $idEntry , $idMultimedia );            
		if(!($OO instanceof AppBlogMultimediaEntries)):            			
			$OO = new AppBlogMultimediaEntries();
            $OO->setEntriesId($idEntry);
            $OO->setMultimediaId($idMultimedia);
            $OO->setSiteId($idS);        
            $OO->setActiu(true);        						
		endif; 
        
        return new AppBlogMultimediaEntriesForm($OO,array('IDS'=>$idS));
                
	}        

    
}
