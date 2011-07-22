<?php

class AppBlogsForms extends BaseAppBlogsForms
{

    public function setInactiu()
    {
        $this->setActiu(false);
        
        $C = new Criteria();
        $C = AppBlogsFormsEntriesPeer::getCriteriaActiu($C,$this->getSiteId());        
        foreach($this->getAppBlogsFormsEntriess($C) as $OFE):
            $OFE->setInactiu();                        
        endforeach;
                
        $this->save();
    }    
    
}
