<?php

class AppBlogsEntries extends BaseAppBlogsEntries
{

    public function setInactiu()
    {
        $this->setActiu(false);
        
        $C = new Criteria();        
        $C = AppBlogMultimediaEntriesPeer::getCriteriaActiu($C,$this->getSiteId());        
        foreach($this->getAppBlogMultimediaEntriess() as $OM):
            $OM->setInactiu();
        endforeach;
                
        $this->save();
    }


	public function getImages()
	{
		$C = new Criteria();
		$C->addJoin(AppBlogsEntriesPeer::ID, AppBlogMultimediaEntriesPeer::ENTRIES_ID);
		$C->addJoin(AppBlogsMultimediaPeer::ID, AppBlogMultimediaEntriesPeer::MULTIMEDIA_ID);
		$C->add(AppBlogsEntriesPeer::ID, $this->getId());
		$RS = AppBlogsMultimediaPeer::doSelect($C);
		if(empty($RS)) return false; 
		else return $RS;		
	}
}
