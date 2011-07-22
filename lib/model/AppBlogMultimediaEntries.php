<?php

class AppBlogMultimediaEntries extends BaseAppBlogMultimediaEntries
{
    
    public function setInactiu()
    {
        $this->setActiu(false);
        
        $C = new Criteria();
        $C = AppBlogsMultimediaPeer::getCriteriaActiu($C,$this->getSiteId());
        foreach($this->getAppBlogsMultimedia($C) as $OM):
            $OM->setInactiu();
        endforeach;
                                
        $this->save();
    }

    
}
