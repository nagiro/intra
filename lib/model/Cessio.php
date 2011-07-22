<?php

class Cessio extends BaseCessio
{
    public function getNomUsuari()
    {            
        $C = new Criteria();
        $C->addJoin(CessioPeer::USUARI_ID, UsuarisPeer::USUARIID);
        $C = CessioPeer::getCriteriaActiu($C,$this->getSiteId());
        $C = UsuarisPeer::getCriteriaActiu($C,$this->getSiteId());
        $C->add(CessioPeer::USUARI_ID, $this->getUsuariId());        
        
        $OU = UsuarisPeer::doSelectOne($C);        
        
        if($OU instanceof Usuaris) { return $OU->getNomComplet(); }
        else { return 'n/d';  }        
    }
}

