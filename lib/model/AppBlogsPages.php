<?php

class AppBlogsPages extends BaseAppBlogsPages
{

    public function setInactiu()
    {
        $this->setActiu(false);
        
        $C = new Criteria();
        $C = AppBlogsEntriesPeer::getCriteriaActiu($C,$this->getSiteId());        
        foreach($this->getAppBlogsEntriess($C) as $OE):
            $OE->setInactiu();                        
        endforeach;
                
        $this->save();
    }


	public function __toString()
	{
		return $this->getId().'. '.$this->getName();
	}
}
