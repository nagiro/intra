<?php

/**
 * Subclass for performing query and update operations on the 'nodes' table.
 *
 * 
 *
 * @package lib.model
 */ 
class NodesPeer extends BaseNodesPeer
{

   static public function getCriteriaActiu($C,$idS)
   {
    $C->add(self::ACTIU, true);
    $C->add(self::SITE_ID, $idS);
    return $C;
   }

 
    static public function initialize($idN , $idS , $editor = false )
	{
		$ON = NodesPeer::retrieveByPK($idN);            
		if(!($ON instanceof Nodes)):            			
			$ON = new Nodes();
            $ON->setSiteId($idS);        
            $ON->setActiu(true);        						
		endif;
        
        if($editor) return new EditorHtmlForm($ON,array('IDS'=>$idS));
        else return new NodesForm($ON,array('IDS'=>$idS));
         
	}
 
  
  static function getNodesSelect()
  {
    $RET = array();

    foreach(self::getNodesActius as $NODE)
    {
      $RET[$NODE->getIdnodes()] = $NODE->getIdnodes().' - '.$NODE->getTitolmenu(); 
    }
    return $RET;
  }
  
  static function retornaMenu($idS , $Tambe_invisibles = false)
  {   	 
  	return self::getNodes( $idS , $Tambe_invisibles );	  		
  }
  
  static function getNodes( $idS , $Tambe_invisibles = false )
  {
  	 $C = new Criteria();
     $C = self::getCriteriaActiu($C,$idS);
  	 if(!$Tambe_invisibles) $C->add(self::ISACTIVA,true);
     $C->addAscendingOrderByColumn(self::ORDRE);
          
     return self::doSelect($C);
  }
  
  static function selectOrdre( $idS , $NOU = false )
  {
     $LOP = self::getNodes($idS,true);
     return myUser::selectOrdre($idS,$LOP,$NOU);     
  }
  
  static function gestionaOrdre( $desti , $actual , $idS )
  {
    
     $NODES = self::getNodes($idS);
     myUser::gestionaOrdre($desti,$actual,$idS,$NODES);
            
  }
  
  static function getIsCategoria($IDN)
  {
  	return self::retrieveByPK($IDN)->getIscategoria();  
  }
  
  static function getIsExterna($IDN)
  {
  	$URL = self::retrieveByPK($IDN)->getUrl();  	
  	return (strlen($URL)>4);  
  }
  
  static public function selectPagina($idNode)
  {
  	$NODE = self::retrieveByPK($idNode);
  	if($NODE instanceof Nodes) return $NODE;
  	else return new Nodes;  	
  }
    
  static public function getFills($NODE)
  {
    $C = new Criteria();
    $NIVELL = $NODE->getNivell();
    $ORDRE = $NODE->getOrdre();
    $C->add(self::ORDRE, $ORDRE , CRITERIA::GREATER_THAN);
    $C->add(self::ISACTIVA, true);
//    $C->add(self::NIVELL, $NIVELL, CRITERIA::GREATER_EQUAL);
    $C->addAscendingOrderByColumn(self::ORDRE);
    return self::doSelect($C);
  }
}