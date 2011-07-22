<?php

/**
 * Subclass for representing a row from the 'usuaris' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Usuaris extends BaseUsuaris
{

	function getPoblacioString()
	{
		$poblacio = $this->getPoblaciotext(); 
		if(!empty($poblacio)):			 
			return $this->getPoblaciotext();
		else:
			$OP = PoblacionsPeer::retrieveByPK($this->getPoblacio());
			if($OP instanceof Poblacions):
				$poblacio = $OP->getNom();
				return $poblacio;
			else:
				return "Desconeguda";
			endif; 		
		endif;
	}
	
  public function __toString(){  return $this->getNomComplet(); }
	
  function getNomComplet(){     
     return $this->getCog1().' '.$this->getCog2().', '.$this->getNom();
  }
   
  public function Check($new)
  {
    $E = array();    
    if( strlen($this->getDNI())   < 7)  $E[] = "No s'ha entrat el DNI o �s incorrecte";     
    if( strlen($this->getNom())   < 1)  $E[] = "No s'ha entrat el NOM";
    if( strlen($this->getCog1())  < 1) $E[] = "Heu d'entrar els COGNOMS.";
    if((strlen($this->getMobil()) < 1) 
     && (strlen($this->getTelefon()) < 1 ) 
     && (strlen($this->getEmail()) < 1 )) $E[] = "Heu d'entrar algun TEL�FON o CORREU ELECTR�NIC.";
    
    $C = new Criteria();    
    $C->add(UsuarisPeer::DNI , $this->getDNI() , Criteria::EQUAL );
    if( UsuarisPeer::doCount($C) > 0 && $new) $E[] = "El DNI ja existeix.";    
    
    return $E;
  }
  
  public function getDades()
  {
  	
  	$RET  = $this->getDni();
  	$RET .= '<br />'.$this->getNomComplet();
  	$RET .= '<br />'.$this->getTelefon();
  	$RET .= '<br />'.$this->getEmail();
  	$RET .= '<br />'.$this->getAdreca();
  	$RET .= '<br />'.$this->getCodipostal().' - '.$this->getPoblaciotext();
  	return $RET;
  	  	
  }
  
  public function getTelefonString()
  {
    
  	$telf = $this->getTelefon();
    $mob  = $this->getMobil();
      	
    if(strlen($telf) > 0 ) return $telf;
    elseif(strlen($telf) > 0) return $mob;
    else return 'n/d';             	
  	  	
  }

    public function getMatricules()
    {
        $C = new Criteria();
        $C = UsuarisPeer::getCriteriaActiu($C,$this->getSiteId());
        $C = MatriculesPeer::getCriteriaActiu($C , $this->getSiteId()); 
        
        $C->addJoin(UsuarisPeer::USUARIID , MatriculesPeer::USUARIS_USUARIID);
        
        $C->add(MatriculesPeer::ESTAT, MatriculesPeer::EN_PROCES , CRITERIA::NOT_EQUAL);
        $C->add(UsuarisPeer::USUARIID, $this->getUsuariid());                
        
        return MatriculesPeer::doSelect($C);        
    }

    public function getReserves()
    {
        $C = new Criteria();
        $C = UsuarisPeer::getCriteriaActiu( $C , $this->getSiteId() );
        $C = ReservaespaisPeer::getCriteriaActiu( $C , $this->getSiteId() ); 
        
        $C->addJoin(UsuarisPeer::USUARIID , ReservaespaisPeer::USUARIS_USUARIID );                
        $C->add(UsuarisPeer::USUARIID, $this->getUsuariid());                
        $C->addDescendingOrderByColumn(ReservaespaisPeer::DATAALTA);
        
        return ReservaespaisPeer::doSelect($C);        
    }

    public function getNivellSite($idS)
    {
        return UsuarisSitesPeer::initialize($this->getUsuariid(),$idS)->getObject()->getNivellId(); 
    }

    public function getDataIniciMatricula()
    {
        $num = MatriculesPeer::getMatriculesUsuari($this->getUsuariid(),$this->getSiteId());
        $D = 0;
        if($num > 0):
            list($Y,$M,$D) = explode('-',OptionsPeer::getString('DATA_MAT_ANTICS',$this->getSiteId()));
            $D = mktime(0,0,0,$M,$D,$Y);                        
        else:
            list($Y,$M,$D) = explode('-',OptionsPeer::getString('DATA_MAT_TOTHOM',$this->getSiteId()));
            $D = mktime(0,0,0,$M,$D,$Y);                    
        endif;
                
        return $D; 
    }
    
    public function getSiteNivell($idS)
    {
        
        $C = new Criteria();
        $C = UsuarisPeer::getCriteriaActiu($C,$idS);
        $C = UsuarisSitesPeer::getCriteriaActiu($C);
        $C->add(UsuarisSitesPeer::SITE_ID, $idS);
        $C->add(UsuarisSitesPeer::USUARI_ID,$this->getUsuariid());        
        
        $OU = UsuarisSitesPeer::doSelectOne($C);                
    
        //Si existeix un vincle entre el site i l'usuari, mirem si quin nivell té.
        //Si no existeix cap vincle, per defecte és registrat.
        if($OU instanceof UsuarisSites):                                    
            if($OU->getNivellId() == NivellsPeer::ADMIN):
                return NivellsPeer::ADMIN;
            else:
                return NivellsPeer::REGISTRAT;
            endif; 
        else: 
            return NivellsPeer::REGISTRAT;        
        endif;        
        
    }   

}