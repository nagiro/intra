<?php

/**
 * Subclass for performing query and update operations on the 'material' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MaterialPeer extends BaseMaterialPeer
{

   static public function getCriteriaActiu($C,$idS)
   {
    $C->add(self::ACTIU, true);
    $C->add(self::SITE_ID, $idS);
    return $C;
   }

  static function inicialitza( $id , $idMG , $idS )
  {
  	
  	$OM = self::retrieveByPK($id);
    
  	if(!($OM instanceof Material)):
  		$OM = new Material();
  		$OM->setMaterialgenericIdmaterialgeneric($idMG);
        $OM->setUnitats(1);  		
        $OM->setSiteId($idS);
        $OM->setActiu(true);                   		
  	endif;
    
    return new MaterialForm($OM,array('IDS'=>$idS));
  	  	
  }

	
  static public function QuantAvui($idS)
  {
     $C = self::criteria($idS);
     $time = date('Y-m-d',mktime(null,null,null,date('m'),date('d')-1,date('Y')));
     $C->add(self::ALTAREGISTRE , $time , Criteria::GREATER_EQUAL );
     return self::doCount($C);
  }

  
  static public function select($idS)
  {
    
    $C = self::criteria($idS);
        
    $RET = array();
    
    foreach(self::doSelect($C) as $M):
      $RET[$M->getIdmaterial()] = $M->getIdentificador().' - '.$M->getNom();    
    endforeach;    
    
    return $RET;    
      
  } 
  
  /**
   * MaterialPeer::selectGeneric()
   * 
   * Retorna una select de material genèric
   * 
   * @param mixed $idG
   * @param mixed $idS
   * @param mixed $idM
   * @return
   */
  static public function selectGeneric($idG, $idS, $idM = null)
  {    
    
	$C = self::criteria($idS);  	    
    $C->add( self::MATERIALGENERIC_IDMATERIALGENERIC , $idG );
    if(!is_null($idM)) $C->add( self::IDMATERIAL , $idM );
    $C->addAscendingOrderByColumn(self::IDENTIFICADOR);    
    
    $RET = array();
  	foreach(self::doSelect($C) as $M):
  		$RET[$M->getIdmaterial()] = $M->toString();
  	endforeach;
  	
  	return $RET;
  	
  }
  
  
  static public function getMaterial($MATERIALGENERIC , $PAGINA = 1, $idS)
  {  	
  	
    $C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    
    if($MATERIALGENERIC > 0) $C->add(self::MATERIALGENERIC_IDMATERIALGENERIC , $MATERIALGENERIC);
    $C->addDescendingOrderByColumn(self::DISPONIBLE);
    $C->addAscendingOrderByColumn(self::IDENTIFICADOR);    
    
    $pager = new sfPropelPager('Material', 40);
	$pager->setCriteria($C);
	$pager->setPage($PAGINA);
	$pager->init();  	
  	return $pager;
    
  }  

  static public function getCriteriaSolapament($C,$di,$df,$vi,$vf,$inclos = true){
    
    if($inclos){
        $C1 = $C->getNewCriterion( $vi , $di , Criteria::GREATER_THAN );
        $C2 = $C->getNewCriterion( $vi , $df , Criteria::LESS_THAN );
        $C3 = $C->getNewCriterion( $vf , $di , Criteria::GREATER_THAN );
        $C4 = $C->getNewCriterion( $vf , $df , Criteria::LESS_THAN );
        $C5 = $C->getNewCriterion( $vi , $di , Criteria::GREATER_EQUAL );
        $C6 = $C->getNewCriterion( $vf , $df , Criteria::LESS_EQUAL );
        $C7 = $C->getNewCriterion( $vi , $di , Criteria::LESS_EQUAL );
        $C8 = $C->getNewCriterion( $vf , $df , Criteria::GREATER_EQUAL );
        $C1->addAnd($C2); $C3->addAnd($C4); $C5->addAnd($C6); $C7->addAnd($C8); 
        $C1->addOr($C3); $C1->addOr($C5); $C1->addOr($C7); 
    } else {
        $C1 = $C->getNewCriterion( $vi , $di , Criteria::GREATER_EQUAL );
        $C2 = $C->getNewCriterion( $vi , $df , Criteria::LESS_EQUAL );
        $C3 = $C->getNewCriterion( $vf , $di , Criteria::GREATER_EQUAL );
        $C4 = $C->getNewCriterion( $vf , $df , Criteria::LESS_EQUAL );
        $C5 = $C->getNewCriterion( $vi , $di , Criteria::GREATER_EQUAL );
        $C6 = $C->getNewCriterion( $vf , $df , Criteria::LESS_EQUAL );
        $C7 = $C->getNewCriterion( $vi , $di , Criteria::LESS_EQUAL );
        $C8 = $C->getNewCriterion( $vf , $df , Criteria::GREATER_EQUAL );
        $C1->addAnd($C2); $C3->addAnd($C4); $C5->addAnd($C6); $C7->addAnd($C8); 
        $C1->addOr($C3); $C1->addOr($C5); $C1->addOr($C7);        
    }
    return $C1;
    
  }

  static public function getOptionsMaterialLliureHores( $datai , $dataf , $hi , $hf , $idS , $idG )
  {
    
    $OCUPAT = self::getMaterialOcupatHores( $datai , $dataf , $hi , $hf , $idS , $idG );
        
    $RET = array();
    
    $C = new Criteria();    
    $C = self::getCriteriaActiu($C,$idS);
    
    $C->add( MaterialPeer::MATERIALGENERIC_IDMATERIALGENERIC , $idG );
    $C->addAscendingOrderByColumn(self::IDENTIFICADOR);
    
    foreach(self::doSelect($C) as $OM):        
        if(!array_key_exists($OM->getIdmaterial(),$OCUPAT)):
            $RET[$OM->getIdmaterial()] = '<option value="'.$OM->getIdmaterial().'">'.addslashes($OM->toString()).'</option>';
        else: 
            $RET[$OM->getIdmaterial()] = '<option value="'.$OM->getIdmaterial().'">(O) '.addslashes($OM->toString()).'</option>';            
        endif;
    endforeach;
    
    return implode(' ',$RET); 

  }

  static private function criteriaOcupatCessio($datai , $dataf , $hi , $hf , $idS , $idG = null , $idH = null , $idC = null)
  {
    //Agafo les activitats que tenen material ocupat una data determinada.
    $C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);    
    $C = CessiomaterialPeer::getCriteriaActiu($C,$idS);
    $C = CessioPeer::getCriteriaActiu($C,$idS);     
                        
    if(!is_null($idG)) $C->add( MaterialPeer::MATERIALGENERIC_IDMATERIALGENERIC , $idG );
    if(!is_null($idC)) $C->add( CessiomaterialPeer::CESSIO_ID, $idC , Criteria::NOT_EQUAL );
    $C->addJoin( self::IDMATERIAL , CessiomaterialPeer::MATERIAL_IDMATERIAL );
    $C->addJoin( CessiomaterialPeer::CESSIO_ID , CessioPeer::CESSIO_ID );            
    $C->addAnd(self::getCriteriaSolapament($C,$datai,$dataf,CessioPeer::DATA_CESSIO, CessioPeer::DATA_RETORN , false ));                 
    $C->add(CessiomaterialPeer::ACTIU, true);
    $C->add(CessioPeer::ACTIU, true);            

    return $C;
  }
      
  static private function criteriaOcupatEspais($datai , $dataf , $hi , $hf , $idS , $idG = null , $idH = null , $idC = null)
  {
    //Mirem les activitats que usen material aquests dies. 
    $C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    $C = HorarisPeer::getCriteriaActiu($C,$idS);
    $C = HorarisespaisPeer::getCriteriaActiu($C,$idS);
    
    $C->addJoin( HorarisPeer::HORARISID , HorarisespaisPeer::HORARIS_HORARISID );
    $C->addJoin( HorarisespaisPeer::MATERIAL_IDMATERIAL , MaterialPeer::IDMATERIAL );
    
    if(!is_null($idG)) $C->add( MaterialPeer::MATERIALGENERIC_IDMATERIALGENERIC , $idG );    
    if(!is_null($idH)) $C->add( HorarisPeer::HORARISID , $idH, Criteria::NOT_EQUAL);
    $C1 = self::getCriteriaSolapament($C,$datai,$dataf,HorarisPeer::DIA,HorarisPeer::DIA);
    $C2 = self::getCriteriaSolapament($C,$hi,$hf,HorarisPeer::HORAPRE, HorarisPeer::HORAPOST);
    $C1->addAnd($C2);    
    $C->addAnd($C1);            
    return $C;    
  }
      
  /**
   * Demano quin material està ocupat en un intèrval 
   * */    
  static private function getMaterialOcupatHores( $datai , $dataf , $hi , $hf , $idS , $idG = null , $idH = null , $idC = null)
  {
    
    $CESSIO = array();
    
    $C = self::criteriaOcupatCessio( $datai , $dataf , $hi , $hf , $idS , $idG , $idH , $idC );        
    foreach(self::doSelect($C) as $OM) $CESSIO[$OM->getIdmaterial()] = $OM;            
      
    $C = self::criteriaOcupatEspais( $datai , $dataf , $hi , $hf , $idS , $idG , $idH , $idC );    
    foreach(self::doSelect($C) as $OM) $CESSIO[$OM->getIdmaterial()] = $OM;    

    return $CESSIO;
                          
  }

  /**
   * Diu si un cert material està lliure un cert dia 
   * */
  static public function isLliure( $idM , $idS , $data , $hi , $hf , $idH = null )
  {
    
    $OCUPAT = self::getMaterialOcupatHores( $data , $data , $hi , $hf , $idS , null, $idH );
    return !array_key_exists($idM, $OCUPAT);
                              
  }

  /**
   * Diu si un material és lliure en un intèrval e temps 
   * */
  static public function isLliureFranja( $idM , $idS , $datai , $dataf , $hi , $hf , $idH = null , $idC = null )
  {
    
    $OCUPAT = self::getMaterialOcupatHores( $datai , $dataf , $hi , $hf , $idS , null, null, $idC );     
    return !array_key_exists($idM, $OCUPAT);
                              
  }

  /**
   * Indica on està ocupat el material en un intèrval de temps 
   * */
  static public function OnOcupatMaterialHores( $idM , $datai , $dataf , $hi , $hf , $idS , $idG = null , $idH = null , $idC = null)
  {
    
    //Busquem primer l'horari en el que està ocupat. 
    //Altrament busquem la cessió en la que està ocupat
    //Agafo les activitats que tenen material ocupat una data determinada.
    $CESSIO = array();
    $C = self::criteriaOcupatCessio( $datai , $dataf , $hi , $hf , $idS , $idG , $idH , $idC );        
    foreach(CessioPeer::doSelect($C) as $OC) $CESSIO[$idM] = $OC;            
      
    $C = self::criteriaOcupatEspais( $datai , $dataf , $hi , $hf , $idS , $idG , $idH , $idC );    
    foreach(HorarisPeer::doSelect($C) as $OH) $CESSIO[$idM] = $OH;    
        
    return $CESSIO;
    
  }

      
  static public function criteria($idS)
  {
    $C = new Criteria();
    $C->add(self::ACTIU , true);
    $C->add(self::SITE_ID , $idS );
    return $C;
  }


  static public function getEstadistiquesMaterial($materials = array(), $site, $month, $year)
  {
    
    $RET= array();
    if(!empty($materials)){
        $SQL = "
            SELECT H.Dia as d, HOUR(H.HoraPre) as hi, HOUR(H.HoraPost) as hf, M.idMaterial as idM, M.Identificador as m_nom
              FROM material M, horarisespais HE, horaris H
             WHERE H.HorarisID = HE.Horaris_HorarisID 
               AND HE.Material_idMaterial = M.idMaterial
               AND H.actiu = 1 AND M.actiu = 1 AND HE.actiu = 1
               AND H.site_id = $site
               AND MONTH(H.Dia) = '$month'
               AND YEAR(H.Dia) = '$year'
               AND HE.Material_idMaterial in (".implode(',',$materials).")
             ORDER BY H.Dia Asc, idM, H.HoraPre Asc";
                                                     
        $con = Propel::getConnection();
        $stmt = $con->prepare($SQL);
        $stmt->execute();         
                 
        while($rs = $stmt->fetch(PDO::FETCH_OBJ)){
            $RET[$rs->d][$rs->idM][$rs->hi] = $rs->hf;    
        } 	


        $SQL_CESSIO = "
            SELECT C.data_cessio as di, C.data_retorn as df, M.idMaterial as idM, M.Identificador as m_nom
              FROM material M, cessio C, cessiomaterial CM
             WHERE M.idMaterial = CM.Material_idMaterial
               AND CM.cessio_id = C.cessio_id
               AND (MONTH(C.data_cessio) = {$month} OR MONTH(C.data_retorn) = {$month})
               AND (YEAR(C.data_cessio) = {$year} OR YEAR(C.data_retorn) = {$year})
               AND M.idMaterial in (".implode(',',$materials).")
               AND M.site_id = 1
               AND M.actiu = 1 AND C.actiu = 1 AND CM.actiu = 1
             ORDER BY C.data_cessio , C.data_retorn         
        ";        

        $con = Propel::getConnection();
        $stmt = $con->prepare($SQL_CESSIO);
        $stmt->execute();                  
        while($rs = $stmt->fetch(PDO::FETCH_OBJ)){
            $di = strtotime($rs->di);
            while($di < $df){
                if(date('m',$di) == $month){
                    $RET[$di][$rs->idM]['CESSIO'] = 'CESSIO';        
                }
                $di = strtotime(date('Y-m-d',$di).' + 1 day');
            }            
        } 	
                
        for($i = 1; $i < 31; $i++):
            $data = date('Y-m-d',strtotime($year.'-'.$month.'-'.$i));        
            foreach($materials as $idM):
                if(!isset($RET[$data][$idM])) $RET[$data][$idM][8] = 8; 
            endforeach;        
            ksort($RET[$data]);
        endfor;
        ksort($RET);
    }
    
    return $RET;
    
  }

  
}
