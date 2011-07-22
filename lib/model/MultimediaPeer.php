<?php

require 'lib/model/om/BaseMultimediaPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'multimedia' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 02/15/11 11:40:28
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class MultimediaPeer extends BaseMultimediaPeer {

    const CONST_ESPAI = 'espais';

    static public function getCriteriaActiu($C,$idS)   
    {
        $C->add(self::SITE_ID, $idS);
        $C->add(self::ACTIU, true);
        return $C;
    } 

    static public function initialize( $idM , $idS , $taula , $idExtern , $i = 0 )
    {
        $OM = MultimediaPeer::retrieveByPK($idM);            
        if(!($OM instanceof Multimedia)):                    	        
        	$OM = new Multimedia();
            $OM->setTaula($taula);
            $OM->setIdextern($idExtern);            
            $OM->setSiteId($idS);
            $OM->setActiu(true);                    
        endif;
        
        return new MultimediaForm($OM,array('I'=>$i,'IDS'=>$idS)); 
    } 

    static public function getFotosEspais( $idE , $idS )
    {
        $C = new Criteria();
        $C = self::getCriteriaActiu($C, $idS);
        $C->add(self::ID_EXTERN, $idE);
        $C->add(self::TAULA, self::CONST_ESPAI);
        return self::doSelect($C);
    }



} // MultimediaPeer