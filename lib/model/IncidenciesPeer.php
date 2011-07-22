<?php

/**
 * Subclass for performing query and update operations on the 'incidencies' table.
 *
 * 
 *
 * @package lib.model
 */ 
class IncidenciesPeer extends BaseIncidenciesPeer
{
   
   const ESTAT_ESPERA = 10;
   const ESTAT_TREBALLANTHI = 20;
   const ESTAT_RESOLT = 30;

  static private function getCriteriaActivu( $C , $idS )
  {    
    $C->add(self::SITE_ID, $idS);
    $C->add(self::ACTIU , true);
    return $C;  
  }     
   
    static public function initialize( $idI , $idU , $idS )
    {
    	$OI = self::retrieveByPK($idI);            
    	if(!($OI instanceof Incidencies)):            
    		$OI = new Incidencies();
    		$OI->setDataalta(time());
    		$OI->setQuiinforma($idU);       
            $OI->setActiu(true);
            $OI->setSiteId($idS);         					
    	endif;
        return new IncidenciesForm($OI,array('IDS'=>$idS)); 
    }
   
   
  static public function QuantesAvui($idS)
  {
     $C = new Criteria();
     $C = self::getCriteriaActivU($C,$idS);     
     $time = mktime(null,null,null,date('m'),date('d')-1,date('Y'));
     $C->add(self::DATAALTA , $time , Criteria::GREATER_EQUAL );     
     return self::doCount($C);
  }
   
  static public function getIncidencies($CERCA = "" , $PAGINA = 1 , $idS , $onlyInProcess = false )
  {
      $C = new Criteria();
      $C = self::getCriteriaActivu( $C , $idS );      
      $C1 = $C->getNewCriterion(self::TITOL , '%'.$CERCA.'%' , Criteria::LIKE);
      $C2 = $C->getNewCriterion(self::DESCRIPCIO , '%'.$CERCA.'%' , Criteria::LIKE);
      $C1->addOr($C2); $C->add($C1);      
      if($onlyInProcess) $C->add(self::ESTAT , self::ESTAT_RESOLT , Criteria::NOT_EQUAL );
      $C->addDescendingOrderByColumn(self::ESTAT);    
   
      $pager = new sfPropelPager('Incidencies', 10);
      $pager->setCriteria($C);
      $pager->setPage($PAGINA);
      $pager->init();  	
      return $pager;
      
  }
  
  static public function getEstatSelect()
  {
     return array( self::ESTAT_ESPERA => 'En espera' , self::ESTAT_TREBALLANTHI => 'Treballant-hi' , self::ESTAT_RESOLT => 'Resolt' );
  }
  
  static public function getIncidenciesUsuari( $idU , $idS )
  {
    $C = new Criteria();
    $C = self::getCriteriaActivu( $C , $idS );
    $C->add( self::ESTAT , self::ESTAT_RESOLT , CRITERIA::NOT_EQUAL );
    $C->add( self::QUIRESOL , $idU );
    return self::doSelect($C);
  }
 
 
     
}
