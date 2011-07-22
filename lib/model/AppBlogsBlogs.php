<?php

class AppBlogsBlogs extends BaseAppBlogsBlogs
{

    public function setInactiu()
    {
        $this->setActiu(false);
        
        $C = new Criteria();
        $C = AppBlogsPagesPeer::getCriteriaActiu($C,$this->getSiteId());
        foreach($this->getAppBlogsPagess($C) as $OP):
            $OP->setInactiu();
        endforeach;

        $C = new Criteria();
        $C = AppBlogsFormsPeer::getCriteriaActiu($C,$this->getSiteId());                        
        foreach($this->getAppBlogsFormss($C) as $OF):
            $OF->setInactiu();
        endforeach;

        $C = new Criteria();
        $C = AppBlogsMenuPeer::getCriteriaActiu($C,$this->getSiteId());                
        foreach($this->getAppBlogsMenus($C) as $OM):
            $OM->setInactiu();
        endforeach;
        
        $this->save();
    }

	public function __toString()
	{
		return $this->getName();
	}
}
