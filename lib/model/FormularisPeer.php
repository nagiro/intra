<?php

require 'lib/model/om/BaseFormularisPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'formularis' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 09/05/11 10:56:55
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class FormularisPeer extends BaseFormularisPeer 
{
  
    static public function getEntitatsHospici($CER)
    {
    
        $C = new Criteria();    
        $C = self::CriteriaCercaFormularisHospici( $CER , $C );
            
        $C->add(SitesPeer::ACTIU, true);      
        $C->addJoin(self::SITE_ID, SitesPeer::SITE_ID);
        
        $RET = array(); $SOL = array();
        
        $RET[0] = array('NOM' => "Totes les entitats..." , 'COUNT'=>0);
        foreach(SitesPeer::doSelect($C) as $OS):
            if(!isset($RET[$OS->getSiteId()])) $RET[$OS->getSiteId()] = array('NOM' => $OS->getNom(),'COUNT'=>0);        
            $RET[$OS->getSiteId()]['COUNT'] += 1;
            $RET[0]['COUNT'] += 1;
        endforeach;
        
        foreach($RET as $K=>$V):
            $SOL[$K] = $V['NOM']." ({$V['COUNT']})";
        endforeach;
        
        return $SOL; 
    }
        
    static private function CriteriaCercaFormularisHospici( $CER , $C )
    {        
                 
        $C->add(self::ACTIU, true);        
    
        if( !empty($CER['TEXT']) ) {
            $C1 = $C->getNewCriterion(self::DESCRIPCIO, '%'.$CER['TEXT'].'%', Criteria::LIKE);
            $C2 = $C->getNewCriterion(self::NOM, '%'.$CER['TEXT'].'%', Criteria::LIKE);            
            $C1->addOr($C2); $C->add($C1);
        }
        
        if( $CER['SITE'] > 0 ){
            $C->add(self::SITE_ID, $CER['SITE']);
        }
                        
        $C->addAscendingOrderByColumn(self::NOM);
        
        return $C;
    
    }
    
    static public function getFormularisCercaHospici($CER)
    {
    
        $C = new Criteria();
           
        $C = self::CriteriaCercaFormularisHospici( $CER , $C );
                                    
        //Ara fem la select dels cursos amb el pager        
        $pager = new sfPropelPager('Formularis', 20);
        $pager->setCriteria($C);
        $pager->setPage($CER['P']);
        $pager->init();    	                
           
        return $pager;

    }
        
} // FormularisPeer
