<?php

/**
 * Subclass for performing query and update operations on the 'agendatelefonicadades' table.
 *
 * 
 *
 * @package lib.model
 */ 
class AgendatelefonicadadesPeer extends BaseAgendatelefonicadadesPeer
{    
   
  static public function getCriteriaActiu($C,$idS)
  {
    $C->add(self::ACTIU, true);
    $C->add(self::SITE_ID , $idS);
    return $C;
  }
   
  static function doSearch( $TEXT , $idS = 1 )
  {
    
     $C = new Criteria();
     $C = AgendatelefonicaPeer::getCriteriaActiu($C,$idS);
     
     $PARAULES = explode(" ",$TEXT); $PAR2 = array();
     foreach( $PARAULES as $P ) if( strlen( $P ) > 2 ): $PAR2[] = trim($P); endif;                      
     
     foreach( $PAR2 as $P ):
      
//      $text1Criterion = $C->getNewCriterion( AgendatelefonicadadesPeer::DADA , '%'.$P.'%', CRITERIA::LIKE);
      $text1Criterion = $C->getNewCriterion( AgendatelefonicaPeer::NOM , '%'.$P.'%', CRITERIA::LIKE);
      $text2Criterion = $C->getNewCriterion( AgendatelefonicaPeer::TAGS , '%'.$P.'%', CRITERIA::LIKE);
      $text3Criterion = $C->getNewCriterion( AgendatelefonicaPeer::ENTITAT , '%'.$P.'%', CRITERIA::LIKE);
      $text1Criterion->addOr($text2Criterion); $text1Criterion->addOr($text3Criterion);  $C->add($text1Criterion);          
     endforeach;
     $C->add(AgendatelefonicaPeer::SITE_ID, $idS);     
     $C->addGroupByColumn( AgendatelefonicaPeer::AGENDATELEFONICAID );     
     $C->addAscendingOrderByColumn( AgendatelefonicaPeer::NOM );
     $C->setLimit(20);
     $ATD = AgendatelefonicaPeer::doSelect($C);
     
     return $ATD; 
  
  }
    
  static public function getSelectHTML($select = 0)
  {
  	$RET = '';
  	foreach(self::select() as $K=>$V):
  	
  		if($K == $select): $RET .= '<option selected value="'.$K.'">'.$V.'</option>';
  		else: $RET .= '<option value="'.$K.'">'.$V.'</option>';  		
  		endif;
  		  	
  	endforeach;
  	
  	$RET = str_replace("'","\'",$RET);
  	
  	return $RET;
  }
  
  static function select(  )
  {
    
     return array(
       	1=>'Telèfon',
       	4=>'Fax',
       	5=>'Email',
  		2=>'Adreça',
  		7=>'Codi Postal',    		  		  		
  		6=>'Població',
  		3=>'Compte corrent'
  		
  		);
  
  }
  
  static function getTipus($idTipus)
  {
  	switch($idTipus){
  		case 1: return 'Telèfon'; break;
  		case 4: return 'Fax'; break;
  		case 5: return 'Email'; break;
  		case 2: return 'Adreça'; break;
  		case 7: return 'Codi Postal'; break;    		  		  		
  		case 6: return 'Població'; break;
  		case 3: return 'Compte corrent'; break;  				
  	}
  }
  
  static public function inArray($Dades,$id)
  {              
    
  	foreach($Dades as $K=>$V):  
  		if($K == $id) return true;  	     
  	endforeach;
  	
  	return false;  	
  }

  static public function inArray2($Dades,$id)
  {              
  	foreach($Dades as $K=>$V):  
  		if($V['id'] == $id) return true;  	     
  	endforeach;
  	
  	return false;  	
  }


  static public function inArrayId($Dades,$id)
  {              
  	foreach($Dades as $K=>$V):  
  		if($V['id'] == $id) return $K;  	     
  	endforeach;
  	
  	return false;  	
  }

  
  static function update($DADES_NOVES,$idA,$idS = 1)
  {
  	
  	$MERGE = array();
  	
  	//Carreguem totes les dades de l'agenda
  	$FOA = AgendatelefonicaPeer::initialize($idA,$idS);
    $DADES_REALS = $FOA->getObject()->getAgendatelefonicadadess();      
                
  	//Primer esborrem tots els que tenim entrats i guardem les seves dades 
  	foreach($DADES_REALS as $K=>$V):
        $V->setActiu(false);
        $V->save();
        $MERGE[$V->getAgendatelefonicadadesid()] = $V;              	   	
  	endforeach;
    
    foreach($DADES_NOVES as $K=>$V):
    
        //Si tenim un id > 0 llavors és update. 
        if($V['id'] > 0):
        
            $MERGE[$V['id']]->setDada($V['Dada']);
            $MERGE[$V['id']]->setNotes($V['Notes']);
            $MERGE[$V['id']]->setTipus($V['Select']);
            $MERGE[$V['id']]->setActiu(true);
            $MERGE[$V['id']]->save();
        
        //Altrament el donem d'alta
        else: 
            
            $DR = new Agendatelefonicadades();  				  				
			$DR->setAgendatelefonicaAgendatelefonicaid($idA);
			$DR->setTipus($V['Select']);
  			$DR->setDada($V['Dada']);
  			$DR->setNotes($V['Notes']);
            $DR->setSiteId($idS);
  			$DR->save();            
        
        endif; 
    
    endforeach;
  	
  }

}
