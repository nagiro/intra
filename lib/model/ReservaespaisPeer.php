<?php

/**
 * Subclass for performing query and update operations on the 'reservaespais' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ReservaespaisPeer extends BaseReservaespaisPeer
{

  const EN_ESPERA = 0;
  const ACCEPTADA = 1;
  const DENEGADA  = 2; 
  const ANULADA   = 3;
  const PENDENT_CONFIRMACIO = 4;
  const ESBORRADA = 5;  


    static public function h_getCriteriaActiu( $C )
    {
        $C->add(self::ACTIU, true);        
        return $C;
    }

    static public function getCriteriaActiu($C,$idS)
    {
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        return $C;
    }


  static public function initialize($idR , $idS , $idU = 0 , $client = false)
  {
    $OR = self::retrieveByPK($idR);            
	if(!($OR instanceof Reservaespais)):                                    			
		$OR = new Reservaespais(); 
  		$OR->setCodi(ReservaespaisPeer::getNextCodi());
        $OR->setUsuarisUsuariid($idU);
        $OR->setEstat(ReservaEspaisPeer::EN_ESPERA);                    
        $OR->setSiteId($idS);        
        $OR->setActiu(true);        		            			    			    			        					
	endif; 

    //Si no s'han guardat les condicions, carreguem per defecte.
    if($OR->getCondicionsccg() == ""){ $OR->setCondicionsccg(ReservaespaisPeer::getCondicionsGeneric($OR,$idS)); }
    if($client) return new ClientReservesForm($OR,array('IDS'=>$idS));
    else return new ReservaespaisForm($OR,array('IDS'=>$idS));
    
  }

  static public function initializeHospici($idR , $idS = 1 , $idE = null , $idU = 0)
  {
    //Mirem si existeix, la carreguem. 
    $OR = self::retrieveByPK($idR);    
	if(!($OR instanceof Reservaespais)):                 
		$OR = new Reservaespais(); 
  		$OR->setCodi(ReservaespaisPeer::getNextCodi());
        $OR->setUsuarisUsuariid($idU);
        $OR->setEstat(ReservaEspaisPeer::EN_ESPERA);
        $OR->setSiteId($idS);        
        $OR->setActiu(true); 
        if(!is_null($idE)) $OR->setEspaissolicitats($idE);
	endif; 
    
    //if($OR->getCondicionsccg() == ""){ $OR->setCondicionsccg(ReservaespaisPeer::getCondicionsGeneric($OR,$idS)); }
    
    return new HospiciReservesForm($OR,array('IDS'=>$idS));
       
  }
  
  static function selectEstat()
  {
     return array(
                    self::EN_ESPERA => 'En espera' ,
                    self::ACCEPTADA => 'Acceptada' ,
                    self::DENEGADA  => 'Denegada',
                    self::ANULADA   => 'Anul·lada',
                    self::PENDENT_CONFIRMACIO => 'Pendent d\'acceptar condicions',
                    self::ESBORRADA => 'Esborrada', 
     );
  }
  
  /**
    * Mostra les reserves pendents que tenim
    *
    * @param int $Pagina
    * @return Reservaespais
    */
   
   static function getReservesSelect($CERCA = "", $SEL = 0 , $Pagina = 1 , $idS )
   {
      $C = new Criteria();
      if(!empty($CERCA)):
      
	      $C1 = $C->getNewCriterion(self::NOM , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C2 = $C->getNewCriterion(self::REPRESENTACIO , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C3 = $C->getNewCriterion(self::RESPONSABLE , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C4 = $C->getNewCriterion(self::PERSONALAUTORITZAT , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C5 = $C->getNewCriterion(self::ORGANITZADORS , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C6 = $C->getNewCriterion(self::DATAACTIVITAT , '%'.$CERCA.'%', CRITERIA::LIKE);          
	      	      	      
	      $C7 = $C->getNewCriterion(UsuarisPeer::NOM , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C8 = $C->getNewCriterion(UsuarisPeer::DNI , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C9 = $C->getNewCriterion(UsuarisPeer::COG1 , '%'.$CERCA.'%', CRITERIA::LIKE);
	      $C10 = $C->getNewCriterion(UsuarisPeer::COG2 , '%'.$CERCA.'%', CRITERIA::LIKE);
	            
	      $C1->addOr($C2); $C1->addOr($C3); $C1->addOr($C4); $C1->addOr($C5); $C1->addOr($C6); 
	      $C1->addOr($C7); $C1->addOr($C8); $C1->addOr($C9); $C1->addOr($C10);
	      
	      $C->add($C1);                            
	      
	  endif;
      
      $C->add( self::SITE_ID , $idS );            
      $C->add( self::ESTAT , self::ESBORRADA , CRITERIA::NOT_EQUAL );
      if($SEL >= 0) $C->add(self::ESTAT, $SEL);
      $C->addDescendingOrderByColumn( self::DATAALTA );
      
                 
      $P = new sfPropelPager('Reservaespais', 20);
      $P->setPeerMethod('doSelectJoinUsuaris');
      $P->setCriteria($C);
      $P->setPage($Pagina);
      $P->init();
      return $P;      
            
   }

   /**
    * Funció que retorna les reserves que ha fet un usuari a qualsevol SITE perquè és per l'Hospici
    *
    * @param int $idU
    * @return Reservaespais
    */
   static function h_getReservesUsuaris( $idU )
   {
      $C = new Criteria();
      $C = self::h_getCriteriaActiu( $C );
      $C->add(ReservaespaisPeer::USUARIS_USUARIID , $idU);
      $C->addDescendingOrderByColumn(self::DATAALTA);
      return ReservaespaisPeer::doSelect($C);
   }


   /**
    * Funció que retorna les reserves que ha fet un usuari a un SITE determinat. 
    *
    * @param int $idU
    * @return Reservaespais
    */
   static function getReservesUsuaris( $idU , $idS )
   {
      $C = new Criteria();
      $C = self::getCriteriaActiu( $C , $idS );
      $C->add(ReservaespaisPeer::USUARIS_USUARIID , $idU);
      return ReservaespaisPeer::doSelect($C);
   }
   
   /**
    * Desa un registre
    *
    * @param array $D
    * @param int $IDU
    * @param int $IDR
    * @return bool/Reservaespais
    */
/*   static function save( $D = array(), $IDU = 0 , $IDR = 0 )   
   {
      $R = new Reservaespais(); $RETURN = array();
      
      if($IDR > 0) { $R = ReservaespaisPeer::retrieveByPK($IDR);  $R->setNew(false);  }
       
      if($IDU > 0) $R->setUsuarisUsuariid($IDU);
      if(!empty($D['REPRESENTACIO'])) $R->setRepresentacio($D['REPRESENTACIO']);
      if(!empty($D['RESPONSABLE'])) $R->setResponsable($D['RESPONSABLE']);
      if(!empty($D['PERSONALAUTORITZAT'])) $R->setPersonalautoritzat($D['PERSONALAUTORITZAT']);
      if(!empty($D['PREVISIOASSISTENTS'])) $R->setPrevisioassistents($D['PREVISIOASSISTENTS']);
      if(!empty($D['ESCICLE'])) $R->setEscicle($D['ESCICLE']);
      if(!empty($D['EXEMPCIO'])) $R->setExempcio($D['EXEMPCIO']);
      if(!empty($D['PRESSUPOST'])) $R->setPressupost($D['PRESSUPOST']);
      if(!empty($D['COLLABORACIO'])) $R->setColaboracioccg($D['COLLABORACIO']);
      if(!empty($D['COMENTARIS'])) $R->setComentaris($D['COMENTARIS']);
      if(!empty($D['ESTAT'])) $R->setEstat($D['ESTAT']); else $R->setEstat(self::EN_ESPERA);
      if(!empty($D['DATAALTA'])) $R->setDataalta(date('Y-m-d',time()));
      if(!empty($D['ORGANITZADORS'])) $R->setOrganitzadors($D['ORGANITZADORS']);
      if(!empty($D['DATAACTIVITAT'])) $R->setDataactivitat($D['DATAACTIVITAT']);
      if(!empty($D['HORARIACTIVITAT'])) $R->setHorariactivitat($D['HORARIACTIVITAT']);
      if(!empty($D['TIPUSACTE'])) $R->setTipusacte($D['TIPUSACTE']);
      if(!empty($D['NOM'])) $R->setNom($D['NOM']);
      if(!empty($D['ISENREGISTRABLE'])) $R->setIsenregistrable($D['ISENREGISTRABLE']);
      if(!empty($D['ESPAIS'])) $R->setEspaissolicitats(implode('@',$D['ESPAIS']));
      if(!empty($D['MATERIAL'])) $R->setMaterialsolicitat(implode('@',$D['MATERIAL']));
      $R->setDataalta(date('Y-m-d',time()));
      $ERRORS = $R->check(); if(empty($ERRORS)) { $R->save(); }      
      return $R;
            
   }
*/      
   static function getNextCodi()
   {
   		$C = new Criteria();
   		$C->addDescendingOrderByColumn(self::RESERVAESPAIID);   		
   		$OO = self::doSelectOne($C);
           		   		   		
   		$O2 = "";
   		if($OO instanceof Reservaespais):
            $O2 = $OO->getReservaespaiid().date('m',time()).date('Y',time());
        else: 
            $O2 = '0'.date('m',time()).date('Y',time());
        endif;  

   		return $O2;
   }
   
   static public function sendMailAnulacio($OR)
   {
    
    $Nom = $OR->getUsuaris()->getNomComplet();
    $DNI = $OR->getUsuaris()->getDni();
    $CODI = $OR->getCodi();
    
    $BODY = "El senyor/a {$Nom} amb DNI {$DNI} ha anul·lat la reserva amb codi {$CODI}"; 
          
	return $BODY; 
    
   }
   
   static public function sendMailNovaReserva($OR)
   {

    $Nom = $OR->getUsuaris()->getNomComplet();
    $DNI = $OR->getUsuaris()->getDni();
    $CODI = $OR->getCodi();
    
    $BODY = "El senyor/a {$Nom} amb DNI {$DNI} ha efectuat la reserva d'espai amb codi {$CODI}"; 
          
	return $BODY; 
        
   }
   
   static public function sendMailCondicions( $OR , $PAREA , $PARER , $idS )
   {
  	
    
    $TEXT = OptionsPeer::getString('RESERVA_ESPAIS_MAILCOND' , $idS );
    $TEXT = str_replace('{{LOGO_URL}}',OptionsPeer::getString('LOGO_URL',$idS) , $TEXT );    
    $TEXT = str_replace('{{MISSATGE}}',$OR->getCondicionsccg() , $TEXT );
    $TEXT = str_replace('{{URL_ACCEPTA}}','http://www.hospici.cat/formularis/'.$PAREA , $TEXT );
    $TEXT = str_replace('{{URL_REBUTJA}}','http://www.hospici.cat/formularis/'.$PARER , $TEXT );
          				
   	return $TEXT; 
    
   }

    /**
     * Carrega el text per defecte de les condicions, que tenim a la variable RESERVA_ESPAIS_CONDICIONS
     * @param $OR Objecte Reserva
     * @param $idS SiteID
     * @return String Missatge que s'envia 
     **/
    static public function getCondicionsGeneric( $OR , $idS )
    {
      	
        $TEXT = OptionsPeer::getString('RESERVA_ESPAIS_CONDICIONS',$idS);
        $TEXT = str_replace('{{REPRESENTACIO}}',$OR->getRepresentacio(),$TEXT);
        $TEXT = str_replace('{{ESPAIS}}',$OR->getEspaisString(),$TEXT);
        $TEXT = str_replace('{{NOM}}',$OR->getNom(),$TEXT);
        $TEXT = str_replace('{{DATA_ACTIVITAT}}',$OR->getDataactivitat(),$TEXT);
        $TEXT = str_replace('{{HORARI_ACTIVITAT}}',$OR->getHorariactivitat(),$TEXT);
        $TEXT = str_replace('{{MATERIAL}}',$OR->getMaterialString(),$TEXT);
                  	
        return $TEXT; 
                
    }

    /**
     * Funció que retorna aquelles reserves que estan en espera de condicions, servirà per enviar recordatoris
     **/
    static public function getReservesRecordatoriNoResposta(){
        
        $C = new Criteria();
        $C->add(self::ACTIU, true);
        $C->add(self::ESTAT, self::PENDENT_CONFIRMACIO);
        return self::doSelect($C);                
        
    }
}
