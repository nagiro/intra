<?php

/**
 * Subclass for performing query and update operations on the 'espais' table.
 *
 * 
 *
 * @package lib.model
 */ 
class EspaisPeer extends BaseEspaisPeer
{

  static public function getCriteriaActiu($C,$idS)
  {
    $C->add(self::ACTIU, true);
    $C->add(self::SITE_ID, $idS);
    return $C;
  }

  static public function initialize( $idE , $idS )
  {
    $OE = self::retrieveByPK($idE);            
	if(!($OE instanceof Espais)):
		$OE = new Espais();   		                    
        $OE->setSiteId($idS);        
        $OE->setActiu(true);        		            			    			    			        					
	endif;    
    
    return new EspaisForm($OE,array('IDS'=>$idS)); 
  }

  static public function select( $idS , $with_new = false )
  {
  	$C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    
  	$C->addAscendingOrderByColumn(self::ORDRE);
  	
    $Espais = self::doSelect($C);
    $RET = array();
    if($with_new) $RET['0'] = 'Nou espai...';
    foreach($Espais as $E):
      $RET[$E->getEspaiid()] = $E->getNom();    
    endforeach;
    
    return $RET;    
      
  }
  
  static public function selectJavascript( $idS , $sel = -1 )
  {

  	$C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    
  	$C->addAscendingOrderByColumn(self::ORDRE);
  	
    $Espais = self::doSelect($C);
  	
    $RET = "";
    foreach($Espais as $E):
    	$idE = $E->getEspaiid();
    	if($sel == $idE): $RET .= '<OPTION SELECTED value="'.$idE.'">'.$E->getNom().'</OPTION>';
    	else: $RET .= '<OPTION value="'.$idE.'">'.$E->getNom().'</OPTION>';
    	endif;    
    endforeach;    
    
    $RET = str_replace("'","\'",$RET);    
    
    return $RET;    
  	
  }


  /**
   * Usat al formulari ClientReservesPeer
   * */  
  static public function selectFormReserva($idS)
  {
    $RET = array();
    $C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    $C->add(EspaisPeer::ISLLOGABLE, true);
    $C->addAscendingOrderByColumn(self::ORDRE);
    foreach(self::doSelect($C) as $E):
    
        $RET[$E->getEspaiid()] = $E->getNom();
    
//        if($E->getEspaiid() >= 1 && $E->getEspaiid() < 6) $RET[$E->getEspaiid()] = $E->getNom();
//        if($E->getEspaiid() >= 9 && $E->getEspaiid() < 16) $RET[$E->getEspaiid()] = $E->getNom();
//        if($E->getEspaiid() == 19) $RET[$E->getEspaiid()] = $E->getNom();          
    
    endforeach;
    return $RET;
  }

  static public function getEspaisSite($idS)
  {
    $C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    $C->addAscendingOrderByColumn(self::ORDRE);
    return self::doSelect($C);
  }

  /**
   * EspaisPeer::getEstadistiquesEspais()
   * 
   * Entrem uns paràmetres de cerca i retorna un array amb l'ocupació d'espais
   * 
   * @param mixed $espais
   * @param mixed $site
   * @param mixed $month
   * @param mixed $year
   * @return
   */
  static public function getEstadistiquesEspais($espais = array(), $site, $month, $year)
  {
    
    $RET= array();
    if(!empty($espais)){
        $SQL = "
            SELECT H.Dia as d, HOUR(H.HoraPre) as hi, HOUR(H.HoraPost) as hf, E.EspaiID as idE, E.Nom as e_nom
              FROM espais E, horarisespais HE, horaris H 
             WHERE H.HorarisID = HE.Horaris_HorarisID 
               AND HE.Espais_EspaiID = E.EspaiID
               AND H.actiu = 1 AND E.actiu = 1 AND HE.actiu = 1
               AND H.site_id = $site                  
               AND MONTH(H.Dia) = '$month'
               AND YEAR(H.Dia) = '$year'
               AND HE.Espais_EspaiID in (".implode(',',$espais).")
             ORDER BY H.Dia Asc, idE, H.HoraPre Asc";
                                           
        $con = Propel::getConnection();
        $stmt = $con->prepare($SQL);
        $stmt->execute(); 
        $RET = array();
                 
        while($rs = $stmt->fetch(PDO::FETCH_OBJ)){
            $RET[$rs->d][$rs->idE][$rs->hi] = $rs->hf;    
        } 	
                        
        for($i = 1; $i < 31; $i++):
            $data = date('Y-m-d',strtotime($year.'-'.$month.'-'.$i));        
            foreach($espais as $idE):
                if(!isset($RET[$data][$idE])) $RET[$data][$idE][8] = 8; 
            endforeach;        
            ksort($RET[$data]);
        endfor;
        ksort($RET);
    }
    
    return $RET;
    
  }


/*******************************************************************************/
/*********************** Funcions per a l'Hospici ******************************/
/*******************************************************************************/

  static public function getCategoriesHospici($CER)
  {
    $C = new Criteria();
//    $C->add(self::ACTIU, true);        
//    $C->add(self::IDCURSOS , $a_cursos , CRITERIA::IN );
//    $C->addJoin(TipusPeer::IDTIPUS, self::CATEGORIA);            
    
//    $RET = array(); $SOL = array();
    
    $RET[0] = array('NOM' => "Totes les categories..." , 'COUNT'=>0);
//    foreach(TipusPeer::doSelect($C) as $OT):
//        if(!isset($RET[$OT->getIdtipus()])) $RET[$OT->getIdtipus()] = array('NOM' => $OT->getTipusdesc(),'COUNT'=>0);        
//        $RET[$OT->getIdtipus()]['COUNT'] += 1;
//        $RET[0]['COUNT'] += 1;
//    endforeach;
        
    foreach($RET as $K=>$V):
//        $SOL[$K] = $V['NOM']." ({$V['COUNT']})";
        $SOL[$K] = $V['NOM'];            
    endforeach;
    
    return $SOL; 
    
  }        
        
  static public function getEntitatsHospici( $CER )
  {
    $C = new Criteria();    
    $C = self::CriteriaCercaEspaisHospici( $CER , $C );
        
    $C->add(SitesPeer::ACTIU, true);      
    $C->addJoin(self::SITE_ID, SitesPeer::SITE_ID);
    
    $RET = array(); $SOL = array();

    $RET[0] = array('NOM' => "Totes les entitats..." , 'COUNT'=>0);
    foreach(SitesPeer::doSelect($C) as $OS):
        if(!isset($RET[$OS->getSiteId()])) $RET[$OS->getSiteId()] = array('NOM' => $OS->getNom(),'COUNT'=>0);        
        $RET[$OS->getSiteId()]['COUNT'] += 1;
        $RET[0]['COUNT'] += 1;
    endforeach;
    
    foreach($RET as $K=>$V):
        $SOL[$K] = $V['NOM']." ({$V['COUNT']})";
    endforeach;
    
    return $SOL; 

  }        
        
  static public function getPoblacionsHospici( $CER )
  {
    $C = new Criteria();
    
    $C = self::CriteriaCercaEspaisHospici( $CER , $C );
    
    
    $C->add(SitesPeer::ACTIU, true);
    $C->addJoin(PoblacionsPeer::IDPOBLACIO, SitesPeer::POBLE);
    $C->addJoin(self::SITE_ID, SitesPeer::SITE_ID);
        
    $RET = array(); $SOL = array();
    
    $RET[0] = array('NOM' => "Tots els pobles..." , 'COUNT'=>0);
    foreach(PoblacionsPeer::doSelect($C) as $OP):
        if(!isset($RET[$OP->getIdpoblacio()])) $RET[$OP->getIdpoblacio()] = array('NOM' => $OP->getNom(),'COUNT'=>0);        
        $RET[$OP->getIdpoblacio()]['COUNT'] += 1;
        $RET[0]['COUNT'] += 1;
    endforeach;
    
    foreach($RET as $K=>$V):
        $SOL[$K] = $V['NOM']." ({$V['COUNT']})";
    endforeach;
    
    return $SOL; 
  }
   
  static private function CriteriaCercaEspaisHospici( $CER , $C ){        
    
    //Agafo els espais que compleixen amb les característiques menys les dates, que les utilitzaré a la sortida.     
    $C->add(self::ACTIU, true);
    $C->add(self::ISLLOGABLE, true);

    if( !empty($CER['TEXT']) ) {
        $C1 = $C->getNewCriterion(self::DESCRIPCIO, '%'.$CER['TEXT'].'%', Criteria::LIKE);
        $C2 = $C->getNewCriterion(self::NOM, '%'.$CER['TEXT'].'%', Criteria::LIKE);
        $C3 = $C->getNewCriterion(SitesPeer::NOM, '%'.$CER['TEXT'].'%', Criteria::LIKE);
        $C1->addOr($C2); $C1->addOr($C3); $C->add($C1);
    }
    
    if( $CER['SITE'] > 0 ){
        $C->add(self::SITE_ID, $CER['SITE']);
    }
    
    if(  $CER['POBLE'] > 0 ){
        $C->addJoin(self::SITE_ID, SitesPeer::SITE_ID);
        $C->add(SitesPeer::POBLE, $CER['POBLE']);
    }
    
    $C->addAscendingOrderByColumn(self::SITE_ID);
    $C->addAscendingOrderByColumn(self::ORDRE);
    
    return $C;
    
  }
        
  static public function getEspaisCercaHospici($CER)
  {
    
    $C = new Criteria();
       
    $C = self::CriteriaCercaEspaisHospici( $CER , $C );
                                
    //Ara fem la select dels cursos amb el pager        
    $pager = new sfPropelPager('Espais', 20);
    $pager->setCriteria($C);
    $pager->setPage($CER['P']);
    $pager->init();    	                
       
    return $pager;
    
  }

}