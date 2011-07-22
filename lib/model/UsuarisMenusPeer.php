<?php

require 'lib/model/om/BaseUsuarisMenusPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'usuaris_menus' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 10/13/10 13:08:30
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class UsuarisMenusPeer extends BaseUsuarisMenusPeer {

    static public function getCriteriaActiu( $C )
    {
      $C->add(self::ACTIU,true);
      return $C;
    }    

  	static public function initialize( $idU , $idM , $idS )
	{	   
	   
		$OO = UsuarisMenusPeer::retrieveByPK($idU,$idM,$idS);           
		if(!($OO instanceof UsuarisMenus)):            			
			$OO = new UsuarisMenus();
            $OO->setUsuariId($idU);
            $OO->setMenuId($idM);
            $OO->setSiteId($idS);
            $OO->setNivellId(NivellsPeer::REGISTRAT);                        
            $OO->setActiu(true);            						
		endif; 
        
        return new UsuarisMenusForm($OO,array('IDS'=>$idS));
                
	}                
    
    static public function doUpdateMy($idU,$idS,$LVALORS)
    {
        $C = new Criteria();
        $C = self::getCriteriaActiu($C);
        $C->add(self::USUARI_ID,$idU);
        $C->add(self::SITE_ID, $idS);
        foreach(self::doSelect($C) as $OMU):
            $OMU->setActiu(false)->save();
        endforeach;
        
        foreach($LVALORS as $idM):
            self::initialize($idU,$idM,$idS)->getObject()->setActiu(true)->save();
        endforeach;
    }
    

} // UsuarisMenusPeer