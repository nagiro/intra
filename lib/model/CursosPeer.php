<?php

/**
 * Subclass for performing query and update operations on the 'cursos' table.
 *
 * 
 *
 * @package lib.model
 */ 
class CursosPeer extends BaseCursosPeer
{

   const CURSACTIU = 1;
   const PASSAT = 0;   

    static public function initialize( $idC , $idS )
    {
        $OC = CursosPeer::retrieveByPK($idC);            
        if(!($OC instanceof Cursos)):                    	
        	$OC = new Cursos();
            $OC->setSiteId($idS);          
            $OC->setActiu(true);                                      	
        endif; 
        return new CursosForm($OC,array('IDS'=>$idS));
    }

   
  static public function getCriteriaActiu( $C , $idS )
  {    
    $C->add(self::ACTIU, true);
    $C->add(self::SITE_ID, $idS);
    return $C;
  }
   
  static function getSelect()
  {
    $RES = array();
    
    $C = new Criteria();
    $CURSOS = CursosPeer::doSelect($C);
    foreach($CURSOS as $CURS):
      $RES[$CURS->getIdcursos()] = $CURS->getCodi().' - '.$CURS->getTitolcurs();    
    endforeach;
       
    return $RES;
     
  }
  
  static function getSelectCategories()
  {
  	
  	$RET = array();
  	$C = new Criteria();
  	$C->add(TipusPeer::TIPUSNOM , 'curs_cat');
  	
  	foreach(tipusPeer::doSelect($C) as $Cat):
  		$RET[$Cat->getIdtipus()] = $Cat->getTipusDesc();
  	endforeach;
  	
  	return $RET;
    
  }
  
  static function getSelectCursos()
  {
  	
	$RET = array();
	$C = new Criteria();
    
    $C->add( self::ISACTIU , true );

	$C->addAscendingOrderByColumn( self::CATEGORIA );
	$C->addDescendingOrderByColumn( self::TITOLCURS );
  	$C->addDescendingOrderByColumn( 'YEAR('.self::DATAINICI.')' );
  	$C->addDescendingOrderByColumn( 'MONTH('.self::DATAINICI.')' );  	
  	
    $RET[0] = 'El curs no està actiu o bé escolliu-ne un';
      	
  	foreach(self::doSelect($C) as $CURS):
  		$DATA = $CURS->getDatafimatricula();  		  		
		list($year,$month,$day) = explode("-",$DATA); 
  		$RET[$CURS->getIdcursos()] = $CURS->getCodi().'('.$year.'-'.$month.') - '.$CURS->getTitolcurs();
  	endforeach;  	    
    
  	return $RET;  	
  	
  }
  
  static function getSelectCursosActius()
  {
  	$RET = array();
	$C = new Criteria();  	
  	$C->add(self::ISACTIU , true);  	
  	$C->addAscendingOrderByColumn( self::CATEGORIA );
  	$C->addAscendingOrderByColumn( self::DATAAPARICIO );	

  	foreach(self::doSelect($C) as $CURS): 
  		$RET[$CURS->getIdcursos()] = $CURS->getCodi().' - '.$CURS->getTitolcurs();
  	endforeach;
  	
  	return $RET;  	
  	
  }
  
  static function getCursos($mode = self::CURSACTIU , $PAGINA = 1, $CERCA = "" , $idS , $visibleWeb = false )
  {
  	$C = new Criteria();  	
    $C = self::getCriteriaActiu($C,$idS);
    
  	if($mode == self::CURSACTIU): $C->add(self::ISACTIU , true); else: $C->add(self::ISACTIU , false); endif;
   
    if($visibleWeb) $C->add(self::VISIBLEWEB, true); //Si ha de ser només per web, marquem com a només els visibles. 
              	
  	$C->addAscendingOrderByColumn( self::CATEGORIA );
  	//$C->addAscendingOrderByColumn( self::DATADESAPARICIO );
  	$C->addAscendingOrderByColumn( self::CODI );
  	
  	if(!empty($CERCA)):
  		$C1 = $C->getNewCriterion(self::CODI, "%$CERCA%" , CRITERIA::LIKE);
  		$C2 = $C->getNewCriterion(self::TITOLCURS , "%$CERCA%" , CRITERIA::LIKE );
		$C1->addOr($C2); $C->add($C1);  		  	
  	endif; 

 	$pager = new sfPropelPager('Cursos', 50);
	$pager->setCriteria($C);
	$pager->setPage($PAGINA);
	$pager->init();  	
  	
  	return $pager;  	
  }
  
  static function getTotsCursos($PAGINA = 1)
  {
  	$C = new Criteria();  	  	  
    $C->addAscendingOrderByColumn( self::CATEGORIA );
  	$C->addAscendingOrderByColumn( self::DATAAPARICIO );
  	
  	$pager = new sfPropelPager('Cursos', 50);
	$pager->setCriteria($C);
	$pager->setPage($PAGINA);
	$pager->init();  	
  	return $pager;  	
  }
      
  static function getMatricules($idC,$idS)
  {
  	$Curs = self::retrieveByPK($idC);
  	$C = new Criteria();
    $C = MatriculesPeer::getCriteriaActiu($C,$idS);
  	$c3 = $C->getNewCriterion(MatriculesPeer::ESTAT,MatriculesPeer::ACCEPTAT_NO_PAGAT);
    $c1 = $C->getNewCriterion(MatriculesPeer::ESTAT,MatriculesPeer::ACCEPTAT_PAGAT);
  	$c2 = $C->getNewCriterion(MatriculesPeer::ESTAT,MatriculesPeer::EN_ESPERA);
  	$c1->addOr($c2); $c1->addOr($c3);
  	$C->add($c1);  	  	
  	$C->addJoin(MatriculesPeer::USUARIS_USUARIID, UsuarisPeer::USUARIID);
    $C->addAscendingOrderByColumn(UsuarisPeer::COG1);
    $C->addAscendingOrderByColumn(UsuarisPeer::COG2);
    $C->addAscendingOrderByColumn(UsuarisPeer::NOM);
  	  	
  	return $Curs->getMatriculess($C);
  }

  /**
   * return array(OCUPADES, TOTAL);
   * */

  static function getPlaces( $idC , $idS )
  {
     
     $FC = self::initialize( $idC , $idS );
     $CURS = $FC->getObject();          
     $MATRICULES = $CURS->countMatriculesActives( $idS );
     $PLACES = $CURS->getPlaces();
     return array('OCUPADES'=>$MATRICULES , 'TOTAL'=>$PLACES);
          
  }
  
  static function isPle( $IDC , $idS )
  {          
     //Si les places ocupades són més grans o igual que el total, el curs és ple
     $PLACES = CursosPeer::getPlaces( $IDC , $idS );
     return ($PLACES['OCUPADES'] >= $PLACES['TOTAL']);              
  }
        
  static function CalculaPreu($IDCURS , $DESCOMPTE , $idS )
  {   
    
     //Recuperem les places del curs
     $PLACES = CursosPeer::getPlaces( $IDCURS , $idS );
     
     //Si les places ocupades són iguals o més que el total, fem la matrícula gratuïta. 
     if($PLACES['OCUPADES'] >= $PLACES['TOTAL']) $DESCOMPTE = MatriculesPeer::REDUCCIO_GRATUIT;

     //Carreguem el curs i retornem el preu reduit o normal segons el que hem entrat     
     $CURS = CursosPeer::retrieveByPK($IDCURS);
     
     switch($DESCOMPTE){
         case MatriculesPeer::REDUCCIO_CAP : return $CURS->getPreu();
         case MatriculesPeer::REDUCCIO_ATURAT : return $CURS->getPreur();
         case MatriculesPeer::REDUCCIO_JUBILAT : return $CURS->getPreur();
         case MatriculesPeer::REDUCCIO_MENOR_25_ANYS : return $CURS->getPreur();
         case MatriculesPeer::REDUCCIO_GRATUIT   : return 0;
         case MatriculesPeer::REDUCCIO_ESPECIAL : return $CURS->getPreur();           
      }
               
  }
  
  
  static function CalculaTotalPreus( $CURSOS , $DESCOMPTE , $idS )
  {   
     $Preu = 0;
     foreach($CURSOS as $C):
        $Preu += self::CalculaPreu($C , $DESCOMPTE , $idS );
     endforeach;     
      
     return $Preu;
  }
  
  static function getCodisAjax($query,$limit)
  {
  	$RET = array();
  	$C = new Criteria();
  	$C->addGroupByColumn(self::CODI);
  	$C->addGroupByColumn(self::TITOLCURS);
  	$C->addAscendingOrderByColumn(self::IDCURSOS);  	
  	$C->add(self::CODI,$query.'%', CRITERIA::LIKE);
  	
  	foreach(self::doSelect($C) as $Curs):
  		$RET[$Curs->getCodi()] = array('clau'=>$Curs->getcodi(),'text'=>$Curs->getCodi().' - '.$Curs->getTitolcurs());  		
  	endforeach;
  	
  	return $RET;
  	
  }
  
  static function getCodisOptions($idS)
  {
  	$RET = array();
  	$C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
  	$C->addGroupByColumn(self::CODI);
  	$C->addGroupByColumn(self::TITOLCURS);
  	$C->addAscendingOrderByColumn(self::CODI);
  	$C->addAscendingOrderByColumn(self::IDCURSOS);  	  	
  	$RET[0] = "Codi de curs nou";
  	foreach(self::doSelect($C) as $Curs):
  		$RET[$Curs->getCodi()] = $Curs->getCodi().' - '.$Curs->getTitolcurs();  		
  	endforeach;
  	
  	return $RET;
  	
  }
  
  static function getCodisTitol()
  {
  	$RET = array();
  	$C = new Criteria();
  	$C->addGroupByColumn(self::CODI);
  	$C->addGroupByColumn(self::TITOLCURS);
  	$C->addAscendingOrderByColumn(self::IDCURSOS);  	  	
  	
  	foreach(self::doSelect($C) as $Curs):
  		$RET['CLAU'][$Curs->getCodi()] = '"'.$Curs->getcodi().'"';  		
  		$RET['TEXT'][$Curs->getCodi()] = '"'.addslashes($Curs->getTitolcurs()).'"';
  	endforeach;
  	
  	return $RET;
  	
  }
    
  static public function getCopyCursByCodi($codi,$idS)
  {
       
  	$OCurs = self::getByCodi($codi,$idS);
  	                           	
  	if($OCurs instanceof Cursos):
        $OCurs->setIdcursos(null);
        $OCurs->setNew(false);
        $FC = new CursosForm($OCurs); 	
        $FC->getObject()->setIsactiu(true);
        $FC->getObject()->setDataaparicio(date('Y-m-d',time()));
        $FC->getObject()->setDatadesaparicio(date('Y-m-d',time()));
        $FC->getObject()->setDatainici(date('Y-m-d',time()));
    else:
        $OC = new Cursos();
        $OC->setSiteId($idS);
        $OC->setActiu(true); 
        $OC->setCodi($codi);
        $FC = new CursosForm($OC);                                	  	
  	endif;
        	
  	return $FC;
  }
  
  static public function getByCodi($codi,$idS)
  {
  	$C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
  	$C->add(self::CODI, $codi);
  	$C->addDescendingOrderByColumn(self::IDCURSOS);
  	return self::doSelectOne($C); 	
  }  

  static public function toTrimestre($m,$y)
  {
    $RET = array();
    if( $m >= 1 && $m <=3 ) $RET = array('ID'=>"1-".$y, 'NOM'=> "Primer trimestre");
    elseif( $m > 3 && $m <=6 ) $RET = array('ID'=>"4-".$y, 'NOM'=> "Segon trimestre");
    elseif( $m > 6 && $m <=9 ) $RET = array('ID'=>"7-".$y, 'NOM'=> "Tercer trimestre");
    elseif( $m > 9 && $m <= 12 ) $RET = array('ID'=>"10-".$y, 'NOM'=> "Quart trimestre");
    return $RET;
  }

  static public function getDatesCursosHospici($a_cursos)
  {
        
    $C = new Criteria();
    $C->add(self::ACTIU, true);        
    $C->add(self::IDCURSOS , $a_cursos , CRITERIA::IN );
    $C->addJoin(TipusPeer::IDTIPUS, self::CATEGORIA);
    
    $RET = array(); $SOL = array();
    
    $RET[0] = array('NOM' => "En el futur..." , 'COUNT'=>0);
    foreach(CursosPeer::doSelect($C) as $OC):
        $m = $OC->getDatainici('m');
        $y = $OC->getDatainici('Y');
        $TRIM = self::toTrimestre($m,$y);
        if(!isset($RET[$TRIM['ID']])) $RET[$TRIM['ID']] = array('NOM' => $TRIM['NOM'].' de '.$y, 'COUNT'=>0 );                
        $RET[$TRIM['ID']]['COUNT'] += 1;
        $RET[0]['COUNT'] += 1;
    endforeach;
            
    krsort($RET);
        
    foreach($RET as $K=>$V):
        $SOL[$K] = $V['NOM']." ({$V['COUNT']})";
    endforeach;
    
    return $SOL;
    
  }        

  static public function getCategoriaCursosHospici($a_cursos)
  {
    $C = new Criteria();
    $C->add(self::ACTIU, true);        
    $C->add(self::IDCURSOS , $a_cursos , CRITERIA::IN );
    $C->addJoin(TipusPeer::IDTIPUS, self::CATEGORIA);            
    
    $RET = array(); $SOL = array();
    
    $RET[0] = array('NOM' => "Totes les categories..." , 'COUNT'=>0);
    foreach(TipusPeer::doSelect($C) as $OT):
        if(!isset($RET[$OT->getIdtipus()])) $RET[$OT->getIdtipus()] = array('NOM' => $OT->getTipusdesc(),'COUNT'=>0);        
        $RET[$OT->getIdtipus()]['COUNT'] += 1;
        $RET[0]['COUNT'] += 1;
    endforeach;
        
    foreach($RET as $K=>$V):
        $SOL[$K] = $V['NOM']." ({$V['COUNT']})";
    endforeach;
    
    return $SOL; 
    
  }        
        
  static public function getEntitatCursosHospici($a_cursos)
  {
    $C = new Criteria();    
    $C->add(self::ACTIU, true);
    $C->add(self::IDCURSOS , $a_cursos , CRITERIA::IN );    
    $C->addJoin(CursosPeer::SITE_ID,SitesPeer::SITE_ID);        
    
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
         
  static public function getPoblacionsCursosHospici($a_cursos)
  {
    $C = new Criteria();    
    $C->add(self::ACTIU, true);
    $C->add(self::IDCURSOS , $a_cursos , CRITERIA::IN );
    $C->addJoin(CursosPeer::SITE_ID,SitesPeer::SITE_ID);    
    $C->addJoin(PoblacionsPeer::IDPOBLACIO, SitesPeer::POBLE);
    
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
        
  static public function getCursosCercaHospici($idText, $idSite, $idPoble, $idCategoria, $idData,  $p)
  {
    
    $WHERE = "c.actiu = 1 AND s.actiu = 1 AND c.VisibleWEB = 1";
    
    //Miro primer què he de filtrar
    if(!empty($idText))  $WHERE .= " AND ( c.TitolCurs like '%$idText%' OR c.Descripcio like '%$idText%' OR c.Codi like '%$idText%' )";
    if(!empty($idSite))  $WHERE .= " AND ( c.site_id = $idSite ) ";
    if(!empty($idPoble)) $WHERE .= " AND ( c.site_id = s.site_id AND s.poble = $idPoble ) ";
    if(!empty($idCategoria)) $WHERE .= " AND ( c.Categoria = $idCategoria ) ";
            
    if(empty($idData) || $idData == 0)
    {
        $idData = date('Y-m-d',time());   
        $WHERE .= " AND c.DataFiMatricula > '$idData' ";
    }
    else 
    { 
        list($m,$y)= explode('-',$idData); 
        $idData = date('Y-m-d',mktime(0,0,0,$m,1,$y)); 
        $idDataf = date('Y-m-d',mktime(0,0,0,$m+3,1,$y));
        $WHERE .= " AND c.DataInici > '$idData' AND c.DataInici < '$idDataf' ";
    }    
        
        
    $SQL = "    SELECT c.idCursos as idC from cursos c, sites s
                 WHERE $WHERE     
    ";
    
    $connection = Propel::getConnection();
    $statement = $connection->prepare($SQL);        
    $statement->execute();
    $RET = array();
    
    //Guardo els elements resultats i els passo a un format Criteria    
    while($result = $statement->fetch(PDO::FETCH_ASSOC)) $RET[$result['idC']] = $result['idC'];
    
    //Ara fem la select dels cursos amb el pager
    $C = new Criteria();    
    $C->add(self::IDCURSOS , $RET , CRITERIA::IN );
    $pager = new sfPropelPager('Cursos', 20);
    $pager->setCriteria($C);
    $pager->setPage($p);
    $pager->init();    	                
       
    return array('PAGER'=>$pager,'LCURSOS'=>$RET);
    
  }
        
}
