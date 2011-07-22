<?php

/**
 * Subclass for representing a row from the 'missatges' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Missatges extends BaseMissatges
{
    public function getSiteNom()
    {
        $idS = $this->getSiteId();
        $OS = SitesPeer::retrieveByPK($idS);
        $Nom = 'n/d';
        if($OS instanceof Sites):
            $Nom = $OS->getNom();
        endif; 
        return $Nom;        
    } 
}
