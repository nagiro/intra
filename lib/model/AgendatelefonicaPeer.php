<?php

/**
 * Subclass for performing query and update operations on the 'agendatelefonica' table.
 *
 * 
 *
 * @package lib.model
 */ 
class AgendatelefonicaPeer extends BaseAgendatelefonicaPeer
{
   
  static public function getCriteriaActiu($C,$IDS)
  {
    $C->add(self::ACTIU, true);
    $C->add(self::SITE_ID,$IDS);
    return $C;
  }
   
  static function getLinies($idS)
  {
     $C = new Criteria();
     $C = self::getCriteriaActiu($C,$idS);
     
     return self::doCount($C);
  }
  
  static function initialize( $id = 0 , $idS = 1)
  {
    
    $OA = self::retrieveByPK($id);        
    
    if(!($OA instanceof Agendatelefonica)):         
        $OA = new Agendatelefonica();
        $OA->setSiteId($idS);
        $OA->setActiu(true);
    endif; 
    
    return new AgendatelefonicaForm($OA);
    
  }
   
}