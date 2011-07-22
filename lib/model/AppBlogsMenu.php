<?php

class AppBlogsMenu extends BaseAppBlogsMenu
{
    
    public function setInactiu()
    {
        $this->setActiu(false);                             
        $this->save();
    }    
    
	public function __toString()
	{
		return $this->getName();
	}
}
