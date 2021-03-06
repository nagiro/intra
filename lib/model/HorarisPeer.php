<?php

/**
 * Subclass for performing query and update operations on the 'horaris' table.
 *
 * 
 *
 * @package lib.model
 */ 
class HorarisPeer extends BaseHorarisPeer
{

  const DESCRIPCIO_WEB = "WEB";

  static public function getCriteriaActiu( $C , $idS )
  {
    $C->add(self::ACTIU,true);
    if(!is_null($idS)) $C->add(self::SITE_ID,$idS);
    return $C;
  }
   	      
  static public function getActivitats($DIA , $TEXT, $DATAI, $DATAF, $IDACTIVITAT , $idS )
  {
    
    $HORARIS = self::cerca($DIA , $TEXT, $DATAI, $DATAF, $IDACTIVITAT , $idS );     
    $RET = ARRAY('ACTIVITATS'=>array(),'CALENDARI'=>array());
    $RET['CALENDARI'] = self::calendari($HORARIS);
    $RET['ACTIVITATS'] = self::activitats($HORARIS);
    
    return $RET;
  
  }

  /**
   * Mostra les activitats al calendari d'agenda
   * */
  static private function activitats($HORARIS)
  {

      $RET = array();
      foreach($HORARIS as $H):     
          $OActivitats = $H->getActivitats();            
	      $RET[$H->getHorarisid()]['ID'] = $OActivitats->getActivitatid();   //Guardem les activitats
	      $RET[$H->getHorarisid()]['NOM_ACTIVITAT'] = $OActivitats->getNom();   //Guardem les activitats
          $RET[$H->getHorarisid()]['ORGANITZADOR'] = $OActivitats->getOrganitzador(); //Guardem l'organitzador	      
	      $RET[$H->getHorarisid()]['DIA'] = $H->getDia('d-m-Y');   //Guardem les activitats
	      $RET[$H->getHorarisid()]['HORA_INICI'] = $H->getHorainici('H:i');   //Guardem les activitats
	      $RET[$H->getHorarisid()]['HORA_FI'] = $H->getHorafi('H:i');   //Guardem les activitats
	      $RET[$H->getHorarisid()]['HORA_PRE'] = $H->getHorapre('H:i');   //Guardem les activitats
	      $RET[$H->getHorarisid()]['HORA_POST'] = $H->getHorapost('H:i');   //Guardem les activitats	      
	      $RET[$H->getHorarisid()]['AVIS'] = $H->getAvis();   //Carreguem l'avís per si de cas          
          $C = HorarisespaisPeer::getCriteriaActiu(new Criteria(),$H->getSiteId());      
	      foreach($H->getHorarisespaiss($C) as $HE):          
	      	$RET[$H->getHorarisid()]['ESPAIS'][$HE->getNomEspai()] = $HE->getNomEspai();   //Guardem les activitats      	
	      	$RET[$H->getHorarisid()]['MATERIAL'][] = (is_null($HE->getMaterial()))?"":$HE->getMaterial()->getIdentificador().' - '.$HE->getMaterial()->getNom();      	
	      endforeach;
	   endforeach;	   
	   return $RET;
     
  }

  
  /**
   * Mostra les activitats que hi ha al calendari d'agenda
   * */ 
  static private function calendari($HORARIS,$GESTIO = true)
  {     
      $RET = array(); $titol = "";
      foreach($HORARIS as $H):
         if($GESTIO): 
            $titol = $H->getActivitats()->getNom();
         else:	         
	        $titol = $H->getActivitats()->getTCurt();	        	         
         endif;             
         if(!empty($titol)):              
            $dia = mktime(0,0,0,$H->getDia('m'),$H->getDia('d'),$H->getDia('Y'));
            $ESPAIS = array();
                        
            foreach($H->getHorarisespaiss() as $HE) $ESPAIS[$HE->getNomEspai()] = $HE->getNomEspai(); 
            
            $RET[$dia][$H->getActivitatsActivitatid()]['ORGANITZADOR']  = $H->getActivitats()->getOrganitzador(); 
		    $RET[$dia][$H->getActivitatsActivitatid()]['ESPAIS']  = implode(' ',$ESPAIS); //Guardem l'hora que acaba            
	        $RET[$dia][$H->getActivitatsActivitatid()]['TITOL'] =  $titol; //Guardem el dia que es fa l'activitat      
		    $RET[$dia][$H->getActivitatsActivitatid()]['HORAI']  = $H->getHorainici('H:i'); //Guardem el dia que es fa l'activitat
		    $RET[$dia][$H->getActivitatsActivitatid()]['HORAF']  = $H->getHorafi('H:i'); //Guardem l'hora que acaba
		    		    
	     endif;	     
      endforeach;
      return $RET;
  }
 
  
  static public function cercaCriteria($DIA , $TEXT, $DATAI, $DATAF, $IDACTIVITAT , $idS )
  {

  	$C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
  	
  	if(!is_null($DIA))   $DIA   = mktime(0,0,0,date('m',$DIA),date('d',$DIA),date('Y',$DIA));
  	if(!is_null($DATAI)) $DATAI = mktime(0,0,0,date('m',$DATAI),date('d',$DATAI),date('Y',$DATAI));
  	if(!is_null($DATAF)) $DATAF = mktime(0,0,0,date('m',$DATAF),date('d',$DATAF),date('Y',$DATAF));
  	  	
    if( !is_null($DIA) ) $C->add(self::DIA, $DIA);
    elseif( !is_null($DATAI) && !is_null($DATAF) ) {
      $data1 = $C->getNewCriterion(self::DIA, $DATAI , CRITERIA::GREATER_EQUAL);
      $data2 = $C->getNewCriterion(self::DIA, $DATAF , CRITERIA::LESS_EQUAL);
      $data1->addAnd($data2);
      $C->add($data1);
    }
    
    foreach(explode(' ',$TEXT) as $PARAULA):
      
      $PARAULA = trim($PARAULA);
    
      if( strlen($PARAULA) > 2 ) {
        $text1Criterion = $C->getNewCriterion(ActivitatsPeer::NOM, '%'.$TEXT.'%', CRITERIA::LIKE);
        $text2Criterion = $C->getNewCriterion(ActivitatsPeer::TMIG , '%'.$TEXT.'%' , CRITERIA::LIKE );
        $text3Criterion = $C->getNewCriterion(ActivitatsPeer::DMIG , '%'.$TEXT.'%' , CRITERIA::LIKE );
        $text4Criterion = $C->getNewCriterion(ActivitatsPeer::TCOMPLET , '%'.$TEXT.'%' , CRITERIA::LIKE );
        $text5Criterion = $C->getNewCriterion(ActivitatsPeer::DCOMPLET , '%'.$TEXT.'%' , CRITERIA::LIKE );
        $text1Criterion->addOr($text2Criterion);
        $text1Criterion->addOr($text3Criterion);
        $text1Criterion->addOr($text4Criterion);
        $text1Criterion->addOr($text5Criterion);
        $C->add($text1Criterion);
      }
    endforeach;
        
    if( !is_null($IDACTIVITAT) ) $C->add(ActivitatsPeer::ACTIVITATSACTIVITATSID, $IDACTIVITAT, CRITERIA::EQUAL ); //Si enviem una idActivitat, la carreguem
    
    $C->addJoin(self::ACTIVITATS_ACTIVITATID,ActivitatsPeer::ACTIVITATID);
    $C = ActivitatsPeer::getCriteriaActiu($C,$idS);
            
    $C->addAscendingOrderByColumn(self::DIA);   //Ordenem per data
    $C->addAscendingOrderByColumn(self::HORAINICI);   //Ordenem per data
  	 
    return $C;
  	
  }
  
  static public function cerca($DIA , $TEXT, $DATAI, $DATAF, $IDACTIVITAT, $idS )
  {
    
  	$C = self::cercaCriteria($DIA , $TEXT, $DATAI, $DATAF, $IDACTIVITAT , $idS );  	          
    return self::doSelectJoinAll($C);
    
  } 
 

/**
 * Comprova que el dia no estigui bloquejat
 * */
  static public function validaDiaBloqueig($DIA, $HORARI, $idS )
  {
  	//Tenim un dia amb bloqueig de tots els espais
	$C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);		    		
    $C->addJoin(self::HORARISID, HorarisespaisPeer::HORARIS_HORARISID);
    $C = HorarisespaisPeer::getCriteriaActiu($C,$idS);
    
    $C->add(self::DIA, $DIA);
	$C->add(HorarisEspaisPeer::ESPAIS_ESPAIID, 22);
	$C->add(self::HORARISID,$HORARI,CRITERIA::NOT_EQUAL);	
                
    return (self::doCount($C) > 0)?1:0;  	
  }  
  
/**
 * Comprova que el dia estigui lliure 
 * */
  static public function validaDia( $DIA , $idE , $HoraPre , $HoraPost , $idH , $idS )
  {
        
    //Garantim que si hi ha un altre espai, no comprovi
    if($idE == 1) $idE = 0;
    
    //Tornar-la a fer per fer-la més criteria; 
    $C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    
    $C->addJoin( self::HORARISID , HorarisespaisPeer::HORARIS_HORARISID );
    $C = HorarisespaisPeer::getCriteriaActiu($C,$idS);
    
    $C->add( HorarisespaisPeer::ESPAIS_ESPAIID, $idE);
    $C->addAnd( MaterialPeer::getCriteriaSolapament($C,$HoraPre,$HoraPost,HorarisPeer::HORAPRE,HorarisPeer::HORAPOST));
    $C->add( self::DIA , $DIA );
        
    if($idH > 0) $C->add(HorarisespaisPeer::HORARIS_HORARISID, $idH , Criteria::NOT_EQUAL);
            
 	return self::doSelect($C);  	  	    		  	
  
  }
      
  static public function save( $HORARIS, $DBDD , $EXTRES , $idS )
  {
        
  	//Carreguem l'horari que estem tractant i guardarem els espais que usa.    
    $A_H = array(); $A_HE = array();
	if($HORARIS['HorarisID'] > 0)
	{ 		
		$OH = HorarisPeer::retrieveByPK($HORARIS['HorarisID']);                
        if($OH instanceof Horaris) $A_H = array($HORARIS['HorarisID']);                        	
		foreach($OH->getHorarisespaiss() as $HE):
            $A_HE[] = $HE->getIdhorarisespais();
		endforeach;
	}	 	
  	    
  	//Per cada un dels dies que ha entrat, creem un horari
  	foreach($DBDD['DIES'] as $D):  		
          
        //Carreguem algun dels horaris que estem editant i el sobreescriurem sinó li donem un número nou
        $idH = array_pop($A_H);
        $OH = (!is_null($idH))?HorarisPeer::retrieveByPK($idH):new Horaris();                        	  	
	  	$OH->setActivitatsActivitatid($HORARIS['Activitats_ActivitatID']);
	  	$OH->setHorainici($DBDD['HoraIn']);
	  	$OH->setHorapre($DBDD['HoraPre']);
	  	$OH->setHorapost($DBDD['HoraPost']);
	  	$OH->setHorafi($DBDD['HoraFi']);
	  	$OH->setAvis($HORARIS['Avis']);
        $OH->setIsentrada($HORARIS['isEntrada']);
	  	$OH->setEspectadors($HORARIS['Espectadors']);
	  	$OH->setPlaces($HORARIS['Places']);
		$OH->setDia($D);
        $OH->setActiu(true);
        $OH->setSiteid($idS);  
                
		$OH->save();  //Guardem				                        
                
        //Si no hi ha espais, vol dir que és un espai extern. Llavors només guardarem el material. 
        if(empty($EXTRES['ESPAISOUT'])){
            $idEE = $EXTRES['ESPAIEXTERN']->getObject()->getIdespaiextern();
            foreach($EXTRES['MATERIALOUT'] as $K=>$idM):
                $idHE = array_pop($A_HE);
                $OHE = (!is_null($idHE))?HorarisespaisPeer::retrieveByPK($idHE):new Horarisespais();
  				$OHE->setMaterialIdmaterial($idM['material']);
  				$OHE->setEspaisEspaiid(null);
  				$OHE->setHorarisHorarisid($OH->getHorarisid());   //Amb l'identificador de l'horari que hem creat
                $OHE->setIdespaiextern($idEE);
                $OHE->setActiu(true);
                $OHE->setSiteid($idS);
  				$OHE->save();                
  			endforeach;
            if(empty($EXTRES['MATERIALOUT'])):
                $idHE = array_pop($A_HE);
                $OHE = (!is_null($idHE))?HorarisespaisPeer::retrieveByPK($idHE):new Horarisespais();
  				$OHE->setMaterialIdmaterial(null);
  				$OHE->setEspaisEspaiid(null);
  				$OHE->setHorarisHorarisid($OH->getHorarisid());   //Amb l'identificador de l'horari que hem creat
                $OHE->setIdespaiextern($idEE);
                $OHE->setActiu(true);
                $OHE->setSiteid($idS);
  				$OHE->save();                            
            endif;                        

        //Han entrat espais i guardem amb el material corresponent                        
        }else{
            
      		foreach($EXTRES['ESPAISOUT'] as $K=>$idE):
      			foreach($EXTRES['MATERIALOUT'] as $K=>$idM):
                    $idHE = array_pop($A_HE);
                    $OHE = (!is_null($idHE))?HorarisespaisPeer::retrieveByPK($idHE):new Horarisespais();                                
      				$OHE->setMaterialIdmaterial($idM['material']);
      				$OHE->setEspaisEspaiid($idE);
      				$OHE->setHorarisHorarisid($OH->getHorarisid());   //Amb l'identificador de l'horari que hem creat
                    $OHE->setIdespaiextern(null);
                    $OHE->setActiu(true);
                    $OHE->setSiteid($idS);
      				$OHE->save();                
      			endforeach;
      			if(empty($EXTRES['MATERIALOUT'])):
                    $idHE = array_pop($A_HE);
                    $OHE = (!is_null($idHE))?HorarisespaisPeer::retrieveByPK($idHE):new Horarisespais();
                    $OHE->setMaterialIdmaterial(null);
      				$OHE->setEspaisEspaiid($idE);
      				$OHE->setHorarisHorarisid($OH->getHorarisid());   //Amb l'identificador de l'horari que hem creat
                    $OHE->setIdespaiextern(null);
                    $OHE->setActiu(true);
                    $OHE->setSiteid($idS);
      				$OHE->save();
      			endif;                
      		endforeach;
            
        }
  			
  	endforeach;
    
   
    //Acabem d'eliminar els que sobrin    
    if(!empty($A_H)) { foreach($A_H as $idH) { HorarisPeer::retrieveByPK($idH)->setInactiu(); }}
    if(!empty($A_HE)) { foreach($A_HE as $idHE) { HorarisespaisPeer::retrieveByPK($idHE)->setInactiu(); }}        
        
  }
  
    static public function getActivitatsDia($D,$idS)
    {
    	$C = new Criteria();
        $C = self::getCriteriaActiu($C,$idS);
        
    	$C->add(self::DIA, $D);
                
    	return self::doSelect($C);
    }
    
      
}