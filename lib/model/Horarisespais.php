<?php

/**
 * Subclass for representing a row from the 'horarisespais' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Horarisespais extends BaseHorarisespais
{

    public function setInactiu()
    {
        $this->setActiu(false);                
        $this->save();                
    }
    
    public function getNomEspai()
    {
        //Si l'espai és null ens quedem amb el nom que apareix a l'horari.
        $idE = $this->getEspaisEspaiid();
        if(is_null($idE)){                
            $OEE = $this->getEspaisExterns();
            if(empty($OEE)) return 'n/d';
            else return $OEE->getNom().' ('.$OEE->getPoblacions()->getNom().')';                         
        
        //Sinó retornem el nom de l'espai que hi ha a la taula espais'
        }else{
            return $this->getEspais()->getNom();
        }
        
    }
    
}
