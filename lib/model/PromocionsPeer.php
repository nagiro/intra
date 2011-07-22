<?php

/**
 * Subclass for performing query and update operations on the 'promocions' table.
 *
 * 
 *
 * @package lib.model
 */ 
class PromocionsPeer extends BasePromocionsPeer
{
    
    static public function getCriteriaActiu($C,$idS)
    {
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        return $C;
    }
    
    static public function initialize($idP , $idS )
    {
    	$OP = PromocionsPeer::retrieveByPK($idP);            
    	if(!($OP instanceof Promocions)):                		    	
    		$OP = new Promocions();
            $OP->setOrdre(0);
            $OP->setSiteId($idS);        
            $OP->setActiu(true);        			
    	endif; 
        
        return new PromocionsForm($OP,array('IDS'=>$idS));
    }

    static public function getAllPromocions($idS,$activa = true)
    {
        $C = new Criteria();
        $C = self::getCriteriaActiu($C,$idS);
        if($activa) $C->add(self::ISACTIVA, true);
        $C->addDescendingOrderByColumn(PromocionsPeer::ISACTIVA);
        $C->addAscendingOrderByColumn(PromocionsPeer::ORDRE);        
        return self::doSelect($C);        
    }

  static function selectOrdre( $idS , $NOU = false )
  {          
     $LOP = self::getAllByOrdre($idS);
     return myUser::selectOrdre($idS,$LOP,$NOU);
  }
	
  static function retrieveByOrdre($idS , $ordre = 1)
  {
    $c = new Criteria;
    $C = self::getCriteriaActiu($C,$idS);
    $c->add(self::ORDRE, $ordre);    
    return self::doSelectOne($c); 
  }
   
  static function getAllByOrdre($idS)
  {
    $C = new Criteria;
    $C = self::getCriteriaActiu($C,$idS);
    $C->addAscendingOrderByColumn(self::ORDRE);
    return self::doSelect($C); 
  }
   
  static function getMaximOrdre($idS)
  {
    $con = Propel::getConnection(self::DATABASE_NAME);
    $sql = 'SELECT MAX('.self::ORDRE.') AS max FROM '.self::TABLE_NAME.' where site_id = '.$idS.' AND actiu = 1'; 
    $stmt = $con->prepareStatement($sql);
    $rs = $stmt->executeQuery();
   
    $rs->next();
    return $rs->getInt('max');
  }  
  
  static function gestionaOrdre( $desti , $actual , $idS )
  {
    
    $NODES = self::getAllByOrdre($idS);    
    myUser::gestionaOrdre($desti,$actual,$idS,$NODES);
    
  }
  
  
  
}
