<?php

/**
 * Subclass for performing query and update operations on the 'cicles' table.
 *
 * 
 *
 * @package lib.model
 */ 
class CiclesPeer extends BaseCiclesPeer
{

   const NO_PERTANY_A_CAP_CICLE = 1;

   static public function getCriteriaActiu( $C , $idS )
   {
    $C->add(self::ACTIU, true);
    $C->add(self::SITE_ID, $idS);
    return $C;
   }	
    
  static public function getSelect($idS)
  {
    $C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    $C->add(self::EXTINGIT, false);
    $C->addAscendingOrderByColumn(self::EXTINGIT);
    $C->addAscendingOrderByColumn(self::NOM);
        
    $ret = array();    
    //$ret[''] = 'No pertany a cap cicle'; 
    foreach(self::doSelect($C) as $C) $ret[$C->getCicleid()] = $C->getNom();
    
    return $ret;
        
  }
    
  static public function initialize($idC,$idS)
  {
  	$OC = self::retrieveByPK($idC);
  	if($OC instanceof Cicles):
  		return new CiclesForm($OC);
  	else: 
  		$OC = new Cicles();
        $OC->setActiu(true);
        $OC->setSiteId($idS);
  		return new CiclesForm($OC);
  	endif; 
  	
  }

/**
 * Use: [ executeGCicles ]
 * Return: Pager
 * Parameters: PAGE(Page), $CERCA(Search), $IDS (IdSite)
 * */  
  static public function getList($PAGE = 1 , $CERCA = "" , $idS )
  {
           
    $C = new Criteria();
    $C = self::getCriteriaActiu( $C , $idS );    
    if(!empty($CERCA)) $C->add(self::NOM,'%'.$CERCA['text'].'%',CRITERIA::LIKE);
    if($CERCA['select'] == 1) $C->add(self::EXTINGIT,false);
    else $C->add(self::EXTINGIT, true);    
    $C->addAscendingOrderByColumn(self::NOM);           
       
    $pager = new sfPropelPager('Cicles', 20);
    $pager->setCriteria($C);
    $pager->setPage($PAGE);
    $pager->init();
    return $pager;

  }
  
  static public function getDataPrimeraActivitat( $idC , $idS )
  {
  	$C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    $C = ActivitatsPeer::getCriteriaActiu($C,$idS);
    
  	$C->addJoin(ActivitatsPeer::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);
  	$C->add(ActivitatsPeer::CICLES_CICLEID,$idC);
  	$C->addAscendingOrderByColumn(HorarisPeer::DIA);
  	
  	$OH = HorarisPeer::doSelectOne($C);
  	
  	if($OH instanceof Horaris) return $OH->getDia('d/m/Y'); 
  	else return 'n/d';
  	
  }
  
  static public function getDataUltimaActivitat( $idC , $idS )
  {
  	$C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    $C = ActivitatsPeer::getCriteriaActiu($C,$idS);
    
  	$C->addJoin(ActivitatsPeer::ACTIVITATID, HorarisPeer::ACTIVITATS_ACTIVITATID);
  	$C->add(ActivitatsPeer::CICLES_CICLEID,$idC);
  	$C->addDescendingOrderByColumn(HorarisPeer::DIA);
  	
  	$OH = HorarisPeer::doSelectOne($C);
  	
  	if($OH instanceof Horaris) return $OH->getDia('d/m/Y'); 
  	else return 'n/d';
  	
  }

  static public function getActivitatsCicle($idC,$idS)
  {
  	$C = new Criteria();  	
    $C = self::getCriteriaActiu($C,$idS);
  	$C->add(ActivitatsPeer::CICLES_CICLEID,$idC);
    $C->add(ActivitatsPeer::PUBLICAWEB, true);
  	$C->addGroupByColumn(ActivitatsPeer::ACTIVITATID);
  	
  	return ActivitatsPeer::doCount($C);
  	
  }  

  static public function getActivitatsCicleList($idC,$idS,$publicaweb = false)
  {
  	$C = new Criteria();  	
    $C = ActivitatsPeer::getCriteriaActiu($C,$idS);
  	$C->add(ActivitatsPeer::CICLES_CICLEID,$idC);
    if($publicaweb) $C->add(ActivitatsPeer::PUBLICAWEB, true);    
  	$C->addGroupByColumn(ActivitatsPeer::ACTIVITATID);
  	
  	return ActivitatsPeer::doSelect($C);
  	
  }  

  
}
