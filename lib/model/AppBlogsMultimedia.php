<?php

class AppBlogsMultimedia extends BaseAppBlogsMultimedia
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
