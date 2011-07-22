<?php

/**
 * Subclass for performing query and update operations on the 'missatges' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MissatgesPeer extends BaseMissatgesPeer
{

  /**
   * Retorna els missatges locals i globals actius.
   * @param Criteria $C
   * @param Site_id  $idS 
   * */
  static function getCriteriaActiu($C,$idS)
  {
    $C->add(self::ACTIU,true);
    $C->add(self::ACTIU, true);
    $C1 = $C->getNewCriterion( self::ISGLOBAL , true );
    $C2 = $C->getNewCriterion( self::SITE_ID  , $idS );
    $C1->addOr($C2); $C->add($C1);    
    return $C;
  }

  static function inicialitza( $id , $idU , $idS )
  {
  	
  	$OM = self::retrieveByPK($id);
  	if($OM instanceof Missatges):
  		return new MissatgesForm($OM);
  	else:
  		$OM = new Missatges();
  		$OM->setUsuarisUsuariid($idU);
  		$OM->setDate(date('Y-m-d',time()));
        $OM->setSiteId($idS);        
  		return new MissatgesForm($OM);  		
  	endif;
  	  	
  }
	
  static function QuantsAvui( $idU , $idS = 1 )
  {
     $C = new Criteria();
     $C = self::getCriteriaActiu($C,$idS);
     $time = mktime(null,null,null,date('m'),date('d')-1,date('Y'));     
     $C->add(self::DATE , $time , Criteria::GREATER_EQUAL );
     $C->add(self::USUARIS_USUARIID , $idU);
     $C->addDescendingOrderByColumn(self::PUBLICACIO);
     return self::doCount($C);
  }
   
  static function doSearch( $TEXT , $PAGE , $ACCIO , $idS )
  {
    
     $C = new Criteria();     

     $C = self::getCriteriaActiu($C,$idS);          
     
     $PARAULES = explode(" ",$TEXT); $PAR2 = array();
     foreach( $PARAULES as $P ) if( strlen( $P ) > 2 ): $PAR2[] = trim($P); endif;                      
     
     foreach( $PAR2 as $P ):
      
      $text1Criterion = $C->getNewCriterion( MissatgesPeer::TITOL , '%'.$P.'%', CRITERIA::LIKE);
      $text2Criterion = $C->getNewCriterion( MissatgesPeer::TEXT , '%'.$P.'%', CRITERIA::LIKE);
      $text1Criterion->addOr($text2Criterion);  $C->add($text1Criterion);          
     endforeach;
     
     $C->addGroupByColumn( MissatgesPeer::MISSATGEID );     
     $C->addDescendingOrderByColumn(self::PUBLICACIO);
     $C->addDescendingOrderByColumn(self::MISSATGEID);
     
     if($ACCIO <> 'SF'):
     	$C->add( MissatgesPeer::PUBLICACIO , date('Y-m-d',time()) , CRITERIA::LESS_EQUAL );
     else:
     	$C->add( MissatgesPeer::PUBLICACIO , date('Y-m-d',time()) , CRITERIA::GREATER_THAN );
     endif;     
                    
     $pager = new sfPropelPager('Missatges', 20);
     $pager->setCriteria($C);
     $pager->setPage($PAGE);
     $pager->init();    
      	          
     return $pager; 
  
  }
  
  static function getMissatgesAvui($idS = 1)
  {
      $C = new Criteria();
      $C = self::getCriteriaActiu($C,$idS);
      $avui = date('Y-m-d',time()); 
      $C->add( self::PUBLICACIO , $avui );      
      $C->addDescendingOrderByColumn(self::PUBLICACIO);
      $C->addDescendingOrderByColumn(self::MISSATGEID);      
      return MissatgesPeer::doSelect($C);
  }
      
}
