<?php

class AppBlogsMultimediaPeer extends BaseAppBlogsMultimediaPeer
{
    
    static public function getCriteriaActiu($C,$idS)
    {
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        return $C;
    }
        
  	static public function initialize( $id , $idS )
	{	   
		$OO = AppBlogsMultimediaPeer::retrieveByPK($id);            
		if(!($OO instanceof AppBlogsMultimedia)):            			
			$OO = new AppBlogsMultimedia();
            $OO->setDate(date('Y-m-d',time()));
            $OO->setDesc("");
            $OO->setSiteId($idS);        
            $OO->setActiu(true);        						
		endif; 
        
        return new AppBlogsMultimediaForm($OO,array('IDS'=>$idS));
                
	}        
    
}
