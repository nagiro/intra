<?php

/**
 * Subclass for performing query and update operations on the 'activitats' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ActivitatsPeer extends BaseActivitatsPeer
{

   const ESTAT_ACTIVITAT_ACCEPTADA = 1;
   const ESTAT_ACTIVITAT_PRERESERVA = 2; 
    
   static public function getCriteriaActiu($C,$idS)
   {
    $C->add(self::ACTIU, true);
    $C->add(self::SITE_ID, $idS);
    return $C;
   }

   //Retorna quantes activitats hi ha avui
   static function QuantesAvui()
   {     
     $H = new Horaris();
     $C = new Criteria();
     $C->add(HorarisPeer::DIA,date('Y-m-d',time()));          
     return HorarisPeer::doCount($C);
   }
   
   static function getNoticies()
   {
      $C = new Criteria();
      $C->add(self::PUBLICAWEB , true);
      $C->addDescendingOrderByColumn(self::ACTIVITATID);      
      return self::doSelect($C);
   }

   
   static function getActivitatsDia( $idS , $dia , $page = 1 )
   {

      $C = new Criteria();
      $C = self::getCriteriaActiu($C,$idS);
      $C = HorarisPeer::getCriteriaActiu($C,$idS);
      
      $C->addJoin(self::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);
      $C->add(HorarisPeer::DIA, $dia);
      $C->add(self::TMIG, '', CRITERIA::NOT_EQUAL);
      $C->add(self::PUBLICAWEB,1);
      $C->addAscendingOrderByColumn(HorarisPeer::HORAINICI);
                
      $pager = new sfPropelPager('Horaris', 20);
	  $pager->setCriteria($C);
      $pager->setPage($page);
      $pager->init();    	
            
      return $pager; 
   }

   static function getActivitatsCerca( $text , $data , $page = 1 , $idS )
   {
   	  $di = mktime(0,0,0,date('m',$data),1,date('Y',$data));            
	  $df = mktime(0,0,0,date('m',$data)+1,1,date('Y',$data));
	  
	  $C = HorarisPeer::cercaCriteria(null,$text,$di,$df,null,$idS);	  
      $C->add(self::TMIG, '', CRITERIA::NOT_EQUAL);
      $C->add(self::PUBLICAWEB,1);      
      $C->addDescendingOrderByColumn(HorarisPeer::DIA);
      $C->addGroupByColumn(self::ACTIVITATID);
                
      $pager = new sfPropelPager('Activitats', 20);
	  $pager->setCriteria($C);
      $pager->setPage($page);
      $pager->init();    	
            
      return $pager; 
   }
   
   
   static function getActivitatsDia2($dia)
   {
      $RET = array();

      $SQL = "
            SELECT A.* , E.*, H.*
              FROM espais E, horarisespais HE, horaris H, activitats A 
             WHERE H.Activitats_ActivitatID = A.ActivitatID 
                  AND H.HorarisID = HE.Horaris_HorarisID 
                  AND HE.Espais_EspaiID = E.EspaiID                  
                  AND H.Dia = '$dia'
                  AND A.tMig <> '' ";
      
     $con = Propel::getConnection(); $stmt = $con->prepare($SQL); $stmt->execute();     
	 
     while($rs = $stmt->fetch(PDO::FETCH_OBJ)): 
     
         $RET[$rs->ActivitatID]['DADES']['ID'] = $rs->ActivitatID; 
         $RET[$rs->ActivitatID]['DADES']['TITOL'] = $rs->tMig;
         $RET[$rs->ActivitatID]['DADES']['TEXT'] = $rs->dMig;
         $RET[$rs->ActivitatID]['DADES']['IMATGE'] = $rs->Imatge;
         $RET[$rs->ActivitatID]['DADES']['PDF'] = $rs->PDF;
         
         $RET[$rs->ActivitatID]['HORARIS'][$rs->HorarisID]['ESPAIS'][] = $rs->Nom;
         $RET[$rs->ActivitatID]['HORARIS'][$rs->HorarisID]['HORAI'] = $rs->HoraInici;
         $RET[$rs->ActivitatID]['HORARIS'][$rs->HorarisID]['HORAF'] = $rs->HoraFi;
         
      endwhile;
          
      return $RET; 
   }
   
   static function getSelectEstats()
   {
   		return array(  self::ESTAT_ACTIVITAT_ACCEPTADA=>'Acceptada',
                       self::ESTAT_ACTIVITAT_PRERESERVA=>'PreReserva');
   }
   
	static public function getTipusEnviaments()
	{
		return array(1=>'El primer dia',2=>'Una setmana abans',3=>'Cada dia d\'activitat');
	}
	
	static public function getTipusEnviamentsSelect()
	{
		return self::getTipusEnviaments();
	}
	
	static public function getTipusEnviamentsSelectValidator()
	{
		$RET = array();
		foreach(self::getTipusEnviaments() as $K=>$V):
		
			$RET[$K] = $K;
		
		endforeach;
		
		return $RET;
	}
	
    static public function initializeDescription($idA,$idS)
    {
        $FA = self::initialize($idA,0,$idS);
        return new ActivitatsTextosForm($FA->getObject(),array('IDS'=>$idS));
    }
    
	static public function initialize($idA , $cicle = 0, $idS )
	{
		$OA = ActivitatsPeer::retrieveByPK($idA);            
		if(!($OA instanceof Activitats)):            			
			$OA = new Activitats();
            $OA->setSiteId($idS);        
            $OA->setActiu(true);        
			if($cicle > 0):
				$OA->setCiclesCicleid($cicle);
			else:
				$OA->setCiclesCicleid(null);
			endif;						
		endif; 
                
        return new ActivitatsForm($OA,array('IDS'=>$idS));
	}
	
	static public function getActivitatsCicles( $idC , $idS , $pager = false, $pagina = 1, $publicaweb = true)
	{
		$C = new Criteria();
        $C = self::getCriteriaActiu($C,$idS);
        
		$C->add(self::CICLES_CICLEID,$idC);
        
        //Afegit per poder ordenar per dia les activitats del cicle
        $C->addJoin(HorarisPeer::ACTIVITATS_ACTIVITATID, self::ACTIVITATID);
        $C = HorarisPeer::getCriteriaActiu($C,$idS);        
        $C->addAscendingOrderByColumn(HorarisPeer::DIA);
        $C->addGroupByColumn(self::ACTIVITATID);        
        
        if($publicaweb) $C->add(self::PUBLICAWEB, true);        
		
		if($pager):
			$pager = new sfPropelPager('Activitats', 20);
			$pager->setCriteria($C);
			$pager->setPage($pagina);
			$pager->init();    		            
			return $pager;
		else: 
			return self::doSelect($C);
		endif; 
				
	}
   	
			
	static public function selectCategories( $idS , $web = false )
	{
		$CAT = array();
		if($web):

			$CAT['cap'] = 'Contingut manual';
		
			$CAT['exposicions-general'] = 'Exposicions i arts visuals - General';
			$CAT['exposicions-historic'] = 'Exposicions i arts visuals - Històric';
			$CAT['exposicions-actual'] = 'Exposicions i arts visuals - Actual';
			
			$CAT['musica-general'] = 'Música i audiovisuals - General';
			$CAT['musica-historic'] = 'Música i audiovisuals - Històric';
			$CAT['musica-actual'] = 'Música i audiovisuals - Actual';
						
			$CAT['esceniques-general'] = 'Arts escèniques i cinema - General';
			$CAT['esceniques-historic'] = 'Arts escèniques i cinema - Històric';
			$CAT['esceniques-actual'] = 'Arts escèniques i cinema - Actual';
						
			$CAT['ciencia-general'] = 'Ciència i humanitats - General';
			$CAT['ciencia-historic'] = 'Ciència i humanitats - Històric';
			$CAT['ciencia-actual'] = 'Ciència i humanitats - Actual';
						
			$CAT['cursos-general'] = 'Cursos - General';
			$CAT['cursos-historic'] = 'Cursos - Historic';
			$CAT['cursos-actual'] = 'Cursos - Actual';
						
			$CAT['altres-general'] = 'Altres - General';
			$CAT['altres-historic'] = 'Altres - Historic ';
			$CAT['altres-actual'] = 'Altres - Actual';
			
		else:
		
			$CAT['exposicions'] = 'Exposicions i arts visuals';
			$CAT['musica'] = 'Música i audiovisuals';
			$CAT['esceniques'] = 'Arts escèniques i cinema';
			$CAT['ciencia'] = 'Ciència i humanitats';
			$CAT['cursos'] = 'Cursos';
			$CAT['altres'] = 'Altres';
			
		endif;		
		
		return $CAT;
	}

	/**
	 * Agafem les activitats d'un tipus del menú i d'un mode determinat i les mostrem ordenades per categoria i dia. 
	 *
	 * @param unknown_type $cat
	 * @param unknown_type $mode
	 * @param unknown_type $idC
	 */
	static public function getActsCategoria($cat,$page = 1, $idC = 0)
	{		
		
		$C = new Criteria();
		
		list($nom,$mode) = explode("-",$cat);
		
		$C->add(self::CATEGORIES,'%'.$cat.'%',CRITERIA::LIKE);	
		$C->addJoin(self::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);
		$C->addJoin(self::CICLES_CICLEID,CiclesPeer::CICLEID);
		
		if($mode == 'historic'):
			$C->add(HorarisPeer::DIA, date('Y-m-d',time()), CRITERIA::LESS_THAN);
			$C->addDescendingOrderByColumn(HorarisPeer::DIA);
		endif;
		 
		if($mode == 'actual'):
			$C->add(HorarisPeer::DIA, date('Y-m-d',time()), CRITERIA::GREATER_EQUAL);
			$C->addAscendingOrderByColumn(HorarisPeer::DIA);
		endif; 
				
		if($idC > 0) $C->add(self::CICLES_CICLEID,$idC);		
		
		$pager = new sfPropelPager('Horaris', 20);
    	$pager->setCriteria($C);
    	$pager->setPage($page);
    	$pager->init();    	
			    	
		return $pager;
				
	}
	
	/**
	 * Agafem els cicles que afecten aquesta categoria i la resta d'activitats que no pertanyen a cap cicle.  
	 *
	 * @param unknown_type $cat
	 * @param unknown_type $mode
	 * @param unknown_type $idC
	 */	
	
	static public function selectCicleCategoriaActivitat( $idS , $cat , $idC = 0 )
	{
		
		$C = new Criteria();
        $C = self::getCriteriaActiu($C,$idS);
        $C = HorarisPeer::getCriteriaActiu($C,$idS);
        $C = CiclesPeer::getCriteriaActiu($C,$idS);
        
		
		list($nom,$mode) = explode("-",$cat);
		
		$C->add(self::CATEGORIES,'%'.$nom.'%',CRITERIA::LIKE);	
		$C->addJoin(self::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);
		$C->addJoin(self::CICLES_CICLEID,CiclesPeer::CICLEID);
		
		if($mode == 'historic'):
			$C->add(HorarisPeer::DIA, date('Y-m-d',time()), CRITERIA::LESS_THAN);
			$C->addDescendingOrderByColumn(HorarisPeer::DIA);
		endif;
		 
		if($mode == 'actual'):
			$C->add(HorarisPeer::DIA, date('Y-m-d',time()), CRITERIA::GREATER_EQUAL);
			$C->addAscendingOrderByColumn(HorarisPeer::DIA);
		endif; 			

		if($idC > 0 ) $C->add(self::CICLES_CICLEID, $idC);
		
		$C->addGroupByColumn(CiclesPeer::CICLEID);
		
		return $C;
		
	}
	
	static public function getCiclesCategoria( $idS , $cat , $page = 1 )
	{		
		
		$C = self::selectCicleCategoriaActivitat( $idS , $cat , 0 );
        $C->add(self::CICLES_CICLEID, 1, CRITERIA::GREATER_THAN);
				
		$pager = new sfPropelPager('Cicles', 20);
    	$pager->setCriteria($C);
    	$pager->setPage($page);
    	$pager->init();    	    	
    	
		return $pager;
				
	}
	
	static public function countActivitatsCiclesCategoria( $cat , $idC = 0 )
	{		
		
		$C = self::selectCicleCategoriaActivitat($cat,$idC);
				
		return self::doCount($C);
								
	}
	
	static public function getPrimerHorariActivitat($IDA,$idS)
	{
		$C = new Criteria();
        $C = HorarisPeer::getCriteriaActiu($C,$idS);
        
		$C->add(HorarisPeer::ACTIVITATS_ACTIVITATID, $IDA);
		$C->addAscendingOrderByColumn(HorarisPeer::DIA);
		
		$OH = HorarisPeer::doSelectOne($C);
		if($OH instanceof Horaris):
			return $OH; 
		else: 
			return null;
		endif; 
	}
    
    static public function getDiesAmbActivitatsMes( $DATACAL , $idS )
    {
        
        $C = new Criteria();
        $C = self::getCriteriaActiu($C,$idS);
        $C = ActivitatsPeer::getCriteriaActiu($C,$idS);
        $C = HorarisPeer::getCriteriaActiu($C,$idS);
        
        $dia_inicial = mktime(0,0,0,date('m',$DATACAL),1,date('Y',$DATACAL));
        $dia_final   = mktime(0,0,0,date('m',$DATACAL)+1,1,date('Y',$DATACAL));
                
        $C->add(ActivitatsPeer::PUBLICAWEB, true);
        $C->addJoin(HorarisPeer::ACTIVITATS_ACTIVITATID, ActivitatsPeer::ACTIVITATID);
        $C->add(HorarisPeer::DIA, $dia_inicial, CRITERIA::GREATER_EQUAL);
        $C->add(HorarisPeer::DIA, $dia_final, CRITERIA::LESS_EQUAL);
        
        $RET = array();
        
        foreach(HorarisPeer::doSelect($C) as $OH):
            $RET[$OH->getDia()] = $OH->getDia();
        endforeach;
        
        return $RET;
    }
    
    /**
     * ActivitatsPeer::getLlistatWord()
     *
     * Fa el select per a un formulari de llistat d'activitats i posterior impressió de word
     *  
     * @param mixed $IAF
     * @param mixed $IDS
     * @return
     */
    static public function getLlistatWord( InformeActivitatsForm $IAF , $IDS )
    {                
        $C = new Criteria();
        $C = ActivitatsPeer::getCriteriaActiu($C,$IDS);
        $C = HorarisPeer::getCriteriaActiu($C,$IDS);
        
        $C->addJoin(ActivitatsPeer::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);                        
        if($IAF->getValue('idCicle') > 0) $C->add(ActivitatsPeer::CICLES_CICLEID, $IAF->getValue('idCicle'));        
        
        $C1 = $C->getNewCriterion(HorarisPeer::DIA,$IAF->getValue('DataInici'),CRITERIA::GREATER_EQUAL);
        $C2 = $C->getNewCriterion(HorarisPeer::DIA,$IAF->getValue('DataFi'),CRITERIA::LESS_EQUAL);                
        if(!is_null($IAF->getValue('DataInici'))) $C->addAnd($C1);
        if(!is_null($IAF->getValue('DataFi'))) $C->addAnd($C2);
        $C->add(ActivitatsPeer::TMIG , "" , CRITERIA::NOT_EQUAL );
        $C->addAscendingOrderByColumn(HorarisPeer::DIA);
        $C->addGroupByColumn(ActivitatsPeer::ACTIVITATID);
        return ActivitatsPeer::doSelect($C);
    }    


  /**
   * ActivitatsPeer::selectSitesActivitats()
   * 
   * Carrega les entitats que hi ha a l'hospici (Per fer)
   *  
   * @return
   */
/*  static public function selectSitesActivitats($text = null)
  {
    $C = new Criteria();
    $C->add(ActivitatsPeer::ACTIU, true);
    $C->add(HorarisPeer::ACTIU, true);
    $C->add(HorarisespaisPeer::ACTIU, true);
    $C->addJoin(ActivitatsPeer::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);
    $C->addJoin(HorarisPeer::HORARISID, HorarisespaisPeer::HORARIS_HORARISID);
    $C->addJoin(SitesPeer::SITE_ID, ActivitatsPeer::SITE_ID);
    $C->addGroupByColumn(ActivitatsPeer::SITE_ID);
    
    if(!empty($text)){
        //$C1 = $C->getNewCriterion(SitesPeer::NOM, '%'.$text.'%',CRITERIA::LIKE);
        $C1 = $C->getNewCriterion(ActivitatsPeer::TMIG, '%'.$text.'%',CRITERIA::LIKE);
        $C2 = $C->getNewCriterion(ActivitatsPeer::DMIG, '%'.$text.'%',CRITERIA::LIKE);
        $C1->addOr($C2); $C->add($C1);
    }
        
    $COUNT = array();
    foreach(SitesPeer::doSelect($C) as $OS){
        if(!isset($COUNT[$OS->getSiteId()]['COUNT'])) $COUNT[$OS->getSiteId()]['COUNT'] = 0;
        $COUNT[$OS->getSiteId()]['NOM'] = $OS->getNom();
        $COUNT[$OS->getSiteId()]['COUNT']++;        
    }          
    
    $FIN = array(); $count = 0;
    $FIN[0] = "";
    foreach($COUNT as $K=>$P){
        $FIN[$K] = $P['NOM'].' ('.$P['COUNT'].')';
        $count += $P['COUNT'];
    }
    $FIN[0] = 'Qualsevol entitat ('.$count.')';
    
    return $FIN;   
    
  }
*/
  
  /**
   * ActivitatsPeer::selectPoblesActivitats()
   * 
   * Omple el llistat de select del portal hospici.   
   * 
   * @return array
   */
/*  static public function selectPoblesActivitats($text = null)
  {
    
    //Busquem les activitats futures amb tots els ets i uts que de moment és la població
    $RET = self::getActivitatsHospiciCerca($text,null,null,null,null,null,true);    
    
    $FIN[0] = ""; $count = 0;
    foreach($RET as $idP => $aActs){
        $nom = PoblacionsPeer::retrieveByPK($idP)->getNom();
        $FIN[$idP] = $nom.' ('.sizeof($aActs).')';
        $count += sizeof($aActs);                            
    }    
    $FIN[0] = "Qualsevol població (".$count.")";
    
    return $FIN;    
             
  }
*/
  /**
   * ActivitatsPeer::selectCategoriesActivitats()
   *
   * Usat en el select de l'hospici que carrega els tipus d'activitats
   *  
   * @param mixed $idP
   * @return
   */
/*  static public function selectCategoriesActivitats( $idP , $text )
  {
    
    //Busquem les activitats futures amb tots els ets i uts que de moment és la població
    $RET = self::getActivitatsHospiciCerca($text,null,$idP,null,null,null,false);    
    
    $where = (sizeof($RET) > 0)?' a.ActivitatID in ('.implode(',',$RET).')':' a.ActivitatID = 0';
    
    $connection = Propel::getConnection();
    $query = 
            "
                Select ta.Nom as nom, ta.idTipusActivitat as ta, count(*) as num 
                  from tipusactivitat ta 
                  LEFT JOIN activitats a ON (ta.idTipusActivitat = a.TipusActivitat_idTipusActivitat)
                 WHERE {$where}                   
                 GROUP BY nom, ta
                 ORDER BY num DESC                  
            ";
    $statement = $connection->prepare($query);
    $statement->execute();
    $RET = array();
    
    //Guardo els elements resultats i els passo a un format Criteria
    $FIN[0] = ""; $count = 0;
    while($P = $statement->fetch(PDO::FETCH_ASSOC)){
        $FIN[$P['ta']] = $P['nom'].' ('.$P['num'].')';
        $count += $P['num'];        
    }    
    $FIN[0] = "Qualsevol categoria (".$count.")";
    
    return $FIN;    
        
  }
*/  
  /**
   * ActivitatsPeer::selectDatesActivitats()
   * 
   * Torna el select de dates amb el volum d'activitats tant per pobles com per entitats
   * 
   * @param mixed $idP
   * @param mixed $idC
   * @return
   */
/*  static public function selectDatesActivitats($idP = null, $idC = null, $text = null, $idE = null)
  {
    
    //Busquem les activitats futures amb tots els ets i uts que de moment és la població
    $RET = self::getActivitatsHospiciCerca($text,null,$idP,$idC,null,null,false);    
    
    $C = new Criteria();
    if(is_null($idE)):
        $C->add(HorarisPeer::ACTIU, true);
        $C->add(HorarisPeer::ACTIVITATS_ACTIVITATID, $RET, CRITERIA::IN);
        $C->addGroupByColumn(HorarisPeer::ACTIVITATS_ACTIVITATID);
    else: 
        if($idE > 0) $C = HorarisPeer::getCriteriaActiu($C,$idE);            
        else $C->add(HorarisPeer::ACTIU, true);        
        $C->add(HorarisPeer::ACTIVITATS_ACTIVITATID, $RET, CRITERIA::IN);
        $C->addGroupByColumn(HorarisPeer::ACTIVITATS_ACTIVITATID);        
    endif;
    
    //Definim els rangs
    $avui = time();
    $capSetmanaDis = $avui;
    while(6 <> date('w',$capSetmanaDis)) $capSetmanaDis = strtotime(date("Y-m-d", $capSetmanaDis) . "+1 day");
    $capSetmanaDiu = strtotime(date('Y-m-d',$capSetmanaDis).' +1 day');
    $fiMes = strtotime(date('Y-m-d',$avui).' +1 month');
    $fi2Mes = strtotime(date('Y-m-d',$avui).' +2 month');
    $fi3Mes = strtotime(date('Y-m-d',$avui).' +3 month');
    
    //Avui
    $C_avui = clone $C;
    $C_avui->add(HorarisPeer::DIA, date('Y-m-d',$avui));        
    $FIN[0] = 'Avui ('.HorarisPeer::doCount($C_avui).')';
    
    //Cap de setmana
    $C_cset = clone $C;
    $C1 = $C_cset->getNewCriterion(HorarisPeer::DIA, date('Y-m-d',$capSetmanaDis));
    $C2 = $C_cset->getNewCriterion(HorarisPeer::DIA, date('Y-m-d',$capSetmanaDiu));
    $C1->addOr($C2); $C_cset->add($C1);    
    $FIN[1] = 'El cap de setmana ('.HorarisPeer::doCount($C_cset).')';

    //Aquest mes
    $C_mes = clone $C;
    $C1 = $C_mes->getNewCriterion(HorarisPeer::DIA, date('Y-m-d',$fiMes), CRITERIA::LESS_THAN);
    $C2 = $C_mes->getNewCriterion(HorarisPeer::DIA, date('Y-m-d',$avui) , CRITERIA::GREATER_EQUAL);
    $C1->addAnd($C2); $C_mes->add($C1);    
    $FIN[2] = 'Aquest mes ('.HorarisPeer::doCount($C_mes).')';
    
    //Dos mesos
    $C_mes2 = clone $C;
    $C1 = $C_mes2->getNewCriterion(HorarisPeer::DIA, date('Y-m-d',$fi2Mes), CRITERIA::LESS_THAN);
    $C2 = $C_mes2->getNewCriterion(HorarisPeer::DIA, date('Y-m-d',$fiMes) , CRITERIA::GREATER_EQUAL);
    $C1->addAnd($C2); $C_mes2->add($C1);    
    $FIN[3] = 'El mes que ve ('.HorarisPeer::doCount($C_mes2).')';
    
    //Tres mesos
    $C_mes3 = clone $C;
    $C1 = $C_mes3->getNewCriterion(HorarisPeer::DIA, date('Y-m-d',$fi3Mes), CRITERIA::LESS_THAN);
    $C2 = $C_mes3->getNewCriterion(HorarisPeer::DIA, date('Y-m-d',$fi2Mes) , CRITERIA::GREATER_EQUAL);
    $C1->addAnd($C2); $C_mes3->add($C1);    
    $FIN[4] = 'El mes que ve ('.HorarisPeer::doCount($C_mes3).')';
                  
    return $FIN;    
        
  }  
*/  

  /**
   * ActivitatsPeer::getActivitatsHospiciCerca()
   *
   * Realitza la consulta unint totes les taules i com a resultat un llistat d'activitats
   *  
   * @param mixed $idText
   * @param mixed $idSite
   * @param mixed $idPoble
   * @param mixed $idCategoria
   * @param mixed $idData
   * @param mixed $aDates
   * @param bool $hasPobles
   * @return
   */
/*  static public function getActivitatsHospiciCerca($idText, $idSite, $idPoble, $idCategoria, $idData, $aDates = null, $hasPobles = false )
  {
                        
    //Segons text
    $idText = addslashes($idText);
    $text = (!is_null($idText) && !empty($idText))?" AND (a.tMig like '%{$idText}%' OR a.dMig like '%{$idText}%')":"";
        
    
    //Segons poble    
    $poble = (!is_null($idPoble) && $idPoble > 0)?' AND p.idPoblacio = '.$idPoble:'';    
    
    //Hem de buscar segons idCategoria.
    $categoria = (!is_null($idCategoria) && $idCategoria > 0)?' AND a.TipusActivitat_idTipusActivitat = '.$idCategoria:'';
    
    $d = webActions::getDatesCercadorHospici($idData,$aDates);
    $datai = $d['datai']; $dataf = $d['dataf'];

    $data = " AND h.Dia >= '".$datai."' AND h.Dia <= '".$dataf."'";                        

    $connection = Propel::getConnection();        
    $query = 
            "
                Select a.ActivitatID as idA, p.idPoblacio as idP, p.Nom as pobleNom
                  from activitats a 
                  LEFT JOIN horaris h ON (a.ActivitatID = h.Activitats_ActivitatID )
                  LEFT JOIN horarisespais he ON (h.HorarisID = he.Horaris_HorarisID)
                  LEFT JOIN espais e ON (he.Espais_EspaiID = e.EspaiID)
                  LEFT JOIN sites s ON (a.site_id = s.site_id)
                  LEFT JOIN poblacions p ON (p.idPoblacio = s.poble)  
                WHERE 
                   a.actiu = 1 AND h.actiu = 1 AND he.actiu = 1 AND e.actiu = 1 AND s.actiu = 1
                   AND a.PublicaWEB = 1
                   {$text}
                   {$poble}
                   {$categoria}
                   {$data}                   
                 GROUP BY idA,idP,pobleNom
                
                UNION
                Select a.ActivitatID as idA, p.idPoblacio as idP, p.Nom as pobleNom
                  from activitats a 
                  LEFT JOIN horaris h ON (a.ActivitatID = h.Activitats_ActivitatID )
                  LEFT JOIN horarisespais he ON (h.HorarisID = he.Horaris_HorarisID)
                  LEFT JOIN espais_externs ee ON (he.idEspaiextern = ee.idEspaiextern)
                  LEFT JOIN sites s ON (a.site_id = s.site_id)
                  LEFT JOIN poblacions p ON (p.idPoblacio = ee.Poble)  
                WHERE 
                   a.actiu = 1 AND h.actiu = 1 AND he.actiu = 1 AND ee.actiu = 1 AND s.actiu = 1
                   AND a.PublicaWEB = 1
                   {$text}
                   {$poble}
                   {$categoria}
                   {$data}
              GROUP BY idA,idP,pobleNom
            ";           
//    echo $query;    
        
    $statement = $connection->prepare($query);        
    $statement->execute();
    $RET = array();
    
    //Guardo els elements resultats i els passo a un format Criteria    
    while($result = $statement->fetch(PDO::FETCH_ASSOC)){
        if($hasPobles):
            $RET[$result['idP']][$result['idA']] = $result['idA'];
        else:
            $RET[$result['idA']] = $result['idA'];
        endif;   
    }
        
    return $RET;
                    
  }
*/
  /**
   * ActivitatsPeer::getActivitatsHospici()
   * 
   * Ens mostra un pager amb les activitats seleccionades
   * 
   * @param mixed $idText
   * @param mixed $idSite
   * @param mixed $idPoble
   * @param mixed $idCategoria
   * @param mixed $idData
   * @param mixed $aDates
   * @param integer $p
   * @return
   */
/*  static public function getActivitatsHospici($idText, $idSite, $idPoble, $idCategoria, $idData, $aDates, $p = 1 )
  {
    
    $RET = self::getActivitatsHospiciCerca($idText, $idSite, $idPoble, $idCategoria, $idData, $aDates, false);    
        
    $C = new Criteria();    
    $C->add(ActivitatsPeer::ACTIVITATID, $RET , CRITERIA::IN );
    $pager = new sfPropelPager('Activitats', 20);
    $pager->setCriteria($C);
    $pager->setPage($p);
    $pager->init();    	
        
    return $pager; 

  }
*/
  static public function getActivitatsCercaHospici($CER){
    $idText         = $CER['TEXT'];
    $idPoble        = $CER['POBLE'];
    $idCategoria    = $CER['CATEGORIA'];
    $idSite         = $CER['SITE'];
    $datai          = myUser::revDate($CER['DATAI']);
    $dataf          = myUser::revDate($CER['DATAF']);
    $p              = $CER['P'];

    $idText = addslashes($idText);    
    $text = (!is_null($idText) && !empty($idText))?" AND (a.tMig like '%{$idText}%' OR a.dMig like '%{$idText}%')":"";             
    $poble = (!is_null($idPoble) && $idPoble > 0)?' AND p.idPoblacio = '.$idPoble:'';            
    $categoria = (!is_null($idCategoria) && $idCategoria > 0)?' AND a.TipusActivitat_idTipusActivitat = '.$idCategoria:'';        
    $data = " AND h.Dia >= '".$datai."' AND h.Dia <= '".$dataf."'";
    $site = ($idSite > 0)?" AND s.site_id = $idSite":"";
                             

    $connection = Propel::getConnection();        
    $query = 
            "                              
               Select a.ActivitatID as idA
                  from activitats a 
                  LEFT JOIN horaris h ON (a.ActivitatID = h.Activitats_ActivitatID )
                  LEFT JOIN horarisespais he ON (h.HorarisID = he.Horaris_HorarisID)
                  LEFT JOIN espais e ON (he.Espais_EspaiID = e.EspaiID)
                  LEFT JOIN sites s ON (a.site_id = s.site_id)
                  LEFT JOIN poblacions p ON (p.idPoblacio = s.poble)  
                WHERE 
                   a.actiu = 1 AND h.actiu = 1 AND he.actiu = 1 AND e.actiu = 1 AND s.actiu = 1
                   AND a.PublicaWEB = 1
                   {$text}
                   {$poble}
                   {$categoria}
                   {$data}
                   {$site}
              GROUP BY idA
                
                UNION
              Select a.ActivitatID as idA
                  from activitats a 
                  LEFT JOIN horaris h ON (a.ActivitatID = h.Activitats_ActivitatID )
                  LEFT JOIN horarisespais he ON (h.HorarisID = he.Horaris_HorarisID)
                  LEFT JOIN espais_externs ee ON (he.idEspaiextern = ee.idEspaiextern)
                  LEFT JOIN sites s ON (a.site_id = s.site_id)
                  LEFT JOIN poblacions p ON (p.idPoblacio = ee.Poble)  
                WHERE 
                   a.actiu = 1 AND h.actiu = 1 AND he.actiu = 1 AND ee.actiu = 1 AND s.actiu = 1
                   AND a.PublicaWEB = 1
                   {$text}
                   {$poble}
                   {$categoria}
                   {$data}
                   {$site}
              GROUP BY idA              
            ";               
            
    $statement = $connection->prepare($query);        
    $statement->execute();
    $RET = array();
    
    //Guardo els elements resultats i els passo a un format Criteria    
    while($result = $statement->fetch(PDO::FETCH_ASSOC)){ $RET[$result['idA']] = $result['idA']; }
    
    //Ara fem la select dels cursos amb el pager
    $C = new Criteria();    
    $C->add(self::ACTIVITATID , $RET , CRITERIA::IN );
    $C->addJoin(HorarisPeer::ACTIVITATS_ACTIVITATID, self::ACTIVITATID);
    $C->addAscendingOrderByColumn(self::TIPUSACTIVITAT_IDTIPUSACTIVITAT);
    $C->addAscendingOrderByColumn(HorarisPeer::DIA);
    $C->addGroupByColumn(self::ACTIVITATID);
    $pager = new sfPropelPager('Activitats', 20);
    $pager->setCriteria($C);    
    $pager->setPage($p);
    $pager->init();    	                
       
    return array('PAGER'=>$pager,'LACTIVITATS'=>$RET);
                  
  }

  /**
   * Funció qeu amb un llistat d'activitats, ens mostra quantes van a cada poble.
   * @param $A_ACTIVITATS (Llistat amb ID activitats)
   * @return SELECT AMB VALORS
   * */  
  public static function getPoblacionsActivitatsHospici($A_ACTIVITATS){
    $C = new Criteria();            
    $C->add( self::ACTIVITATID , $A_ACTIVITATS , CRITERIA::IN );
    $C->addJoin( self::ACTIVITATID , HorarisPeer::ACTIVITATS_ACTIVITATID  );
    $C->addJoin( HorarisPeer::HORARISID , HorarisespaisPeer::HORARIS_HORARISID);
    $C->addJoin( HorarisespaisPeer::ESPAIS_ESPAIID , EspaisPeer::ESPAIID );
    $C->addJoin( EspaisPeer::SITE_ID , SitesPeer::SITE_ID );
    $C->addJoin( SitesPeer::POBLE , PoblacionsPeer::IDPOBLACIO );
    $C->addGroupByColumn( self::ACTIVITATID );
    
    $C2 = new Criteria();            
    $C2->add( self::ACTIVITATID , $A_ACTIVITATS , CRITERIA::IN );
    $C2->addJoin( self::ACTIVITATID , HorarisPeer::ACTIVITATS_ACTIVITATID  );
    $C2->addJoin( HorarisPeer::HORARISID , HorarisespaisPeer::HORARIS_HORARISID);
    $C2->addJoin( HorarisespaisPeer::IDESPAIEXTERN , EspaisExternsPeer::IDESPAIEXTERN );
    $C2->addJoin( EspaisexternsPeer::POBLE , PoblacionsPeer::IDPOBLACIO );
    $C2->addGroupByColumn( self::ACTIVITATID );    
                    
    $RET = array(); $SOL = array();
    
    $RET[0] = array('NOM' => "Tots els pobles..." , 'COUNT'=>0);
    foreach(PoblacionsPeer::doSelect($C) as $OP):
        if(!isset($RET[$OP->getIdpoblacio()])) $RET[$OP->getIdpoblacio()] = array('NOM' => $OP->getNom(),'COUNT'=>0);
        $RET[$OP->getIdpoblacio()]['COUNT'] += 1;
        $RET[0]['COUNT'] += 1;
    endforeach;

    foreach(PoblacionsPeer::doSelect($C2) as $OP):
        if(!isset($RET[$OP->getIdpoblacio()])) $RET[$OP->getIdpoblacio()] = array('NOM' => $OP->getNom(),'COUNT'=>0);
        $RET[$OP->getIdpoblacio()]['COUNT'] += 1;
        $RET[0]['COUNT'] += 1;
    endforeach;    
        
    foreach($RET as $K=>$V):
        $SOL[$K] = $V['NOM']." ({$V['COUNT']})";
    endforeach;
    
    return $SOL; 
    
  }
  
  /**
   * Funció qeu amb un llistat d'activitats, ens mostra a quines entitats s'executen.
   * @param $A_ACTIVITATS (Llistat amb ID activitats)
   * @return SELECT AMB VALORS
   * */  
  public static function getEntitatsActivitatsHospici($A_ACTIVITATS){    
    $C = new Criteria();
    $C->add( self::ACTIVITATID , $A_ACTIVITATS , CRITERIA::IN );
    $C->addJoin( self::SITE_ID , SitesPeer::SITE_ID );    
    $C->addGroupByColumn( self::ACTIVITATID );
                    
    $RET = array(); $SOL = array();
    
    $RET[0] = array('NOM' => "Tots els pobles..." , 'COUNT'=>0);
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
  
  /**
   * Funció qeu amb un llistat d'activitats, ens mostra a quines entitats s'executen.
   * @param $A_ACTIVITATS (Llistat amb ID activitats)
   * @return SELECT AMB VALORS
   * */  
  public static function getCategoriaActivitatsHospici($A_ACTIVITATS){
    $C = new Criteria();
    $C->add( self::ACTIVITATID , $A_ACTIVITATS , CRITERIA::IN );
    $C->addJoin( self::TIPUSACTIVITAT_IDTIPUSACTIVITAT , TipusactivitatPeer::IDTIPUSACTIVITAT );
    $C->addGroupByColumn( self::ACTIVITATID );    
                    
    $RET = array(); $SOL = array();
    
    $RET[0] = array('NOM' => "Tots els tipus..." , 'COUNT'=>0);
    foreach(TipusactivitatPeer::doSelect($C) as $OT):
        if(!isset($RET[$OT->getIdtipusactivitat()])) $RET[$OT->getIdtipusactivitat()] = array('NOM' => $OT->getNom(),'COUNT'=>0);
        $RET[$OT->getIdtipusactivitat()]['COUNT'] += 1;
        $RET[0]['COUNT'] += 1;
    endforeach;
        
    foreach($RET as $K=>$V):
        $SOL[$K] = $V['NOM']." ({$V['COUNT']})";
    endforeach;
    
    return $SOL; 
    
  }  

    /**
     * Funció que retorna els horaris que tenen entrades a la venta. S'usa bàsicament a la gestió de reserves.
     * @param $P Pàgina actual
     * @param $idS Site que està consultant
     * @return Pager d'Horaris()
     * */
    static public function cercaActivitatsVenta($P = 1, $idS = 1)
    {
        
        $connection = Propel::getConnection();        
        $query =         
                "                              
                   SELECT a.ActivitatID as idA, a.Nom as nom, a.Places as places, min(h.Dia) as dia, min(h.HoraInici) as hora
                     FROM activitats a, horaris h                       
                    WHERE a.actiu = 1 AND h.actiu = 1 
                      AND h.Activitats_ActivitatID = a.ActivitatID
                      AND a.isEntrada = true
                      AND a.site_id = $idS
                    GROUP BY idA, nom, places                                                           
                    HAVING MIN(h.Dia) AND MIN(h.HoraInici)
                    ORDER BY dia desc, hora asc                    
                ";               
                
        $statement = $connection->prepare($query);        
        $statement->execute();
        $RET = array();
        
        //Guardo els elements resultats i els passo a un format Criteria
        $mida = 20;
        $i = 0; $min = ($P-1)*$mida; $max = $min + $mida;    
        while($res = $statement->fetch(PDO::FETCH_ASSOC)){
            if( $i >= $min && $i < $max ):
                $RET[$res['idA']] = array(  'nom'=>$res['nom'],
                                            'places'=>$res['places'],
                                            'dia'=>$res['dia'],
                                            'hora'=>$res['hora']);        
            endif;
            $i++;
          }                  	

        return $RET;
        
    }


}