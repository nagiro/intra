<?php

/**
 * Subclass for performing query and update operations on the 'tasques' table.
 *
 * 
 *
 * @package lib.model
 */ 
class TasquesPeer extends BaseTasquesPeer
{

	static public function getCercaTasques($QUAN,$IDU,$PAGINA,$JOFAIG)
	{
		$C = new Criteria();
		if($QUAN == 1):			     //Avui
		    $IN = date( "Y-m-d" , mktime( 0 , 0 , 0 , date( 'm' , time() ) , date( 'd' , time() )   , date( 'Y' , time() ) ) );
		    $FI = date( "Y-m-d" , mktime( 0 , 0 , 0 , date( 'm' , time() ) , date( 'd' , time() )   , date( 'Y' , time() ) ) );
		elseif($QUAN == 2):			//Setmanal
			$IN = date( "Y-m-d" , mktime( 0 , 0 , 0 , date( 'm' , time() ) , date( 'd' , time() )   , date( 'Y' , time() ) ) );
		    $FI = date( "Y-m-d" , mktime( 0 , 0 , 0 , date( 'm' , time() ) , date( 'd' , time() )+7 , date( 'Y' , time() ) ) );	
		elseif($QUAN == 3):			//Mensual
			$IN = date( "Y-m-d" , mktime( 0 , 0 , 0 , date( 'm' , time() )   , date( 'd' , time() )   , date( 'Y' , time() ) ) );
		    $FI = date( "Y-m-d" , mktime( 0 , 0 , 0 , date( 'm' , time() ) + 1 , date( 'd' , time() ) , date( 'Y' , time() ) ) );
		else:
			$IN = date( "Y-m-d" , mktime( 0 , 0 , 0 , date( 'm' , time() ) , date( 'd' , time() )   , date( 'Y' , time() ) ) );
		    $FI = date( "Y-m-d" , mktime( 0 , 0 , 0 , date( 'm' , time() ) , date( 'd' , time() )   , date( 'Y' , time() ) ) );				
		endif;
	    
	    if($JOFAIG) $C->add( TasquesPeer::QUIFA , $IDU );
    	else $C->add( TasquesPeer::QUIMANA , $IDU );
	    	        
	    $C1 = $C->getNewCriterion( TasquesPeer::APARICIO    , $IN , CRITERIA::GREATER_EQUAL );
	    $C2 = $C->getNewCriterion( TasquesPeer::APARICIO    , $FI , CRITERIA::LESS_EQUAL );
	    $C1->addAnd($C2);
	                
	    $C3 = $C->getNewCriterion( TasquesPeer::DESAPARICIO , $IN , CRITERIA::GREATER_EQUAL );
	    $C4 = $C->getNewCriterion( TasquesPeer::DESAPARICIO , $FI , CRITERIA::LESS_EQUAL );
	    $C3->addAnd($C4);
	    
	    $C5 = $C->getNewCriterion( TasquesPeer::APARICIO    , $IN , CRITERIA::LESS_EQUAL );
	    $C6 = $C->getNewCriterion( TasquesPeer::DESAPARICIO , $FI , CRITERIA::GREATER_EQUAL );
	    $C5->addAnd($C6);
	    
	    $C1->addOr($C3); $C1->addOr($C5);
	    
	    $C->add($C1);    
	    
	    $C->addAscendingOrderByColumn( TasquesPeer::ISFETA );
	    $C->addAscendingOrderByColumn( TasquesPeer::DESAPARICIO );
	    $C->addAscendingOrderByColumn( TasquesPeer::TASQUESID );
	    
	    $C->addGroupByColumn( TasquesPeer::TASQUESID );
	
	    $pager = new sfPropelPager('Tasques', 10);
		$pager->setCriteria($C);
		$pager->setPage($PAGINA);
		$pager->init();
	    
	    return $pager;
				
	}
	
  static public function QuantesAvui($EnsTocaFer,$idU)
  {
     $C = new Criteria();
     $time = mktime(null,null,null,date('m'),date('d')-1,date('Y'));
     $C->add(self::ALTAREGISTRE , $time , Criteria::GREATER_EQUAL );
     if($EnsTocaFer) $C->add(self::QUIFA,$idU); else $C->add(self::QUIMANA,$idU);
     return self::doCount($C);
  }
   

}
