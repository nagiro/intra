<?php

/**
 * Subclass for representing a row from the 'activitats' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Activitats extends BaseActivitats
{

    public function getEntradesHoraris()
    {
        //Si de l'activitat actual se'n opden comprar entrades
        if($this->getIsentrada() == true):                    
            //Carreguem els horaris que tinguin isEntrada = 1
            $C = new Criteria();
            $C->add(HorarisPeer::ISENTRADA, true);
            $LHO = $this->getHorariss($C);                        
            return $LHO;        
        else: 
            return array();
        endif; 
    }

    public function getNomTipusActivitat()
    {
        $OTA = $this->getTipusactivitat();
        $NOM = "n/d";
        
        if($OTA instanceof Tipusactivitat) $NOM = $OTA->getNom();    
        
        return $NOM;
    }
    
    public function setInactiu()
    {
        $this->setActiu(false);
        $C = new Criteria();
        $C = HorarisPeer::getCriteriaActiu($C,$this->getSiteid());
        
        foreach($this->getHorariss($C) as $OH):
            $OH->setInactiu();
        endforeach;        
        
        $this->save();                
    }
    
   public function getEspais()
   {
      $RET = array();
      $con = Propel::getConnection();
      $stmt = $con->createStatement();
      $idA = $this->getActivitatid();
      $SQL = "
               SELECT E.*
                 FROM espais E, horarisespais HE, horaris H 
                WHERE H.Activitats_ActivitatID = $idA 
                  AND H.HorarisID = HE.Horaris_HorarisID 
                  AND HE.Espais_EspaiID = E.EspaiID
                  GROUP BY E.Nom
                  ";
      $rs = $stmt->executeQuery($SQL,ResultSet::FETCHMODE_NUM);      
      foreach(EspaisPeer::populateObjects($rs) as $E):
         $RET[] = $E->getNom();      
      endforeach;
      return $RET;
   }
   
   public function get7DiesAbansData()
   {
   	
   		$H = $this->getHorariss();
   		if($H[0] instanceof Horaris):
   		
   			list($any,$mes,$dia) = explode("-",$H[0]->getDia());
   			$time = mktime(0,0,0,$mes,$dia-7,$any);
   			return date('Y-m-d',$time);   			
   			
   		else:
   		
   			return date('Y-m-d',time());
   		
   		endif;
   	
   }
   
   public function getHorariss($criteria = null, PropelPDO $con = null)
   {
        $C = $criteria;
        if(is_null($criteria)) $C = new Criteria();
        
        $C = HorarisPeer::getCriteriaActiu($C,$this->getSiteId());
        return parent::getHorariss($C,null);
   }
   
   
   public function getPrimeraData()
   {   	                        
   		$H = $this->getHorariss();
   		if(isset($H[0]) && $H[0] instanceof Horaris):
   		
   			list($any,$mes,$dia) = explode("-",$H[0]->getDia());
   			$time = mktime(0,0,0,$mes,$dia,$any);
   			return date('Y-m-d',$time);   			
   			
   		else:
   		
   			return date('-----',time());
   		
   		endif;
   	
   }

   public function getPrimerHorari()
   {   	                        
        $C = new Criteria();
        $C->addAscendingOrderByColumn(HorarisPeer::DIA);
        
   		$H = $this->getHorariss($C);
        if($H[0] instanceof Horaris) return $H[0];        
        else return null;          	
   }

   
   public function getHorarisOrdenats($camp)
   {
        $C = new Criteria();
        $C = HorarisPeer::getCriteriaActiu($C,$this->getSiteId());
        $C->addAscendingOrderByColumn($camp);
        return $this->getHorariss($C);
   }
   
   public function countHorarisActius($idS)
   {
     $C = new Criteria();
     $C = HorarisPeer::getCriteriaActiu($C,$idS);     
     return $this->countHorariss($C);
   }
   
   public function getHorarisActius($idS)
   {    
     $C = new Criteria();
     $C = HorarisPeer::getCriteriaActiu($C,$idS);
     $C->addAscendingOrderByColumn(HorarisPeer::DIA);     
     return $this->getHorariss($C);    
   }

   public function getNomSite()
   {    
     return SitesPeer::getNom($this->getSiteId());
   }

   public function getNomForUrl()
   {
        $nom = $this->getTmig();
        return myUser::text2url($nom);        
   }

    /**
     * Retorna si una activitat ja no té més entrades a la venta. 
     * */
   public function getIsPle()
   {
        return (EntradesReservaPeer::countEntradesActivitatConf($this->getActivitatid()) >= $this->getPlaces());        
   }
   
}
