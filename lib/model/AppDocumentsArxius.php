<?php

class AppDocumentsArxius extends BaseAppDocumentsArxius
{
    
    public function setInactiu()
    {
        $this->setActiu(false);                        
        $this->save();
    }    
    
}
