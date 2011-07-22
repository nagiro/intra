<?php

/**
 * Subclass for representing a row from the 'espais' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Espais extends BaseEspais
{
    public function __toString()
    {
        return $this->getNom();
    }
    
    public function getNomForUrl()
    {
        $nom = $this->getNom();
        return myUser::text2url($nom);        

    }
    
    public function getFotos()
    {
        return MultimediaPeer::getFotosEspais($this->getEspaiid(), $this->getSiteId());        
    }

    public function getSiteName()
    {
        $OS = SitesPeer::retrieveByPK($this->getSiteId());
        if($OS instanceof Sites) return $OS->getNom();
        else return 'n/d';        
    }
    
}
