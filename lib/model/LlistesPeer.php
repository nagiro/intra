<?php

/**
 * Subclass for performing query and update operations on the 'llistes' table.
 *
 * 
 *
 * @package lib.model
 */ 
class LlistesPeer extends BaseLlistesPeer
{
   
  const TOTS = 0;
  const ENVIATS = 1;
  const NO_ENVIATS = 2;
   
    static public function getCriteriaActiu($C,$idS)
    {
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        return $C;
    }
        
  	static public function initialize( $idL , $idS )
	{	   
		$OL = LlistesPeer::retrieveByPK($idL);            
		if(!($OL instanceof Llistes)):            			
			$OL = new Llistes();            
            $OL->setSiteId($idS);        
            $OL->setActiu(true);        						
		endif; 
        
        return new LlistesForm($OL,array('IDS'=>$idS));
	}

   
   
  //Torna un Select amb les llistes que hi ha disponibles
  static public function select($idS){
     
     $C = new Criteria();
     $C = self::getCriteriaActiu($C,$idS);
     $C->add(LlistesPeer::ISACTIVA , true); 
     
     $SELECT = array();     
     foreach(LlistesPeer::doSelect($C) as $L):        
        $SELECT[$L->getIdllistes()] = $L->getNom();
     endforeach;
     return $SELECT;
  }
   
  /**
   * Donada una llista i un usuari, els desvincula
   *
   */
  static public function desvincula($IDU, $IDL)
  {
      
       $C = new Criteria();
       $C->add(UsuarisllistesPeer::LLISTES_IDLLISTES , $IDL);
       $C->add(UsuarisllistesPeer::USUARIS_USUARISID , $IDU);
       
       foreach(UsuarisllistesPeer::doSelect($C) as $ULP):
          $ULP->delete();
       endforeach;
  }
  
 /**
   * Donada una llista i un usuari, els desvincula
   *
   */
  static public function vincula($IDU, $IDL)
  {
     
      $UL = new Usuarisllistes();
      $UL->setNew(true);
      $UL->setUsuarisUsuarisid($IDU);
      $UL->setLlistesIdllistes($IDL);
      $UL->save();
      
  }
  
  
  static public function getLlistesDisponibles( $IDU , $idS )
  {
     $SELECT = array();
               
     foreach(self::select($idS) as $K=>$L):
        $C = new Criteria();     
        $C->add( UsuarisllistesPeer::USUARIS_USUARISID , $IDU );
        $C->add( UsuarisllistesPeer::LLISTES_IDLLISTES , $K );
        if(UsuarisllistesPeer::doCount($C) == 0) $SELECT[$K] = $L;                 
     endforeach;          
     return $SELECT;
  }

  static public function getLlistesAll($idS)
  {
    $C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    return self::doSelect($C);
  }

  /**
   * Retorna els missatges d'una llista
   *
   * @param INT $MODALITAT
   */
  static public function getMissatges($IDL , $MODALITAT , $PAGINA = 1 , $idS )  
  {
     $C = new Criteria();
     $C = self::getCriteriaActiu( $C , $idS );
     $C = MissatgesllistesPeer::getCriteriaActiu( $C , $idS );
     
     $C->add( MissatgesllistesPeer::LLISTES_IDLLISTES , $IDL );
     $C->addJoin(MissatgesllistesPeer::IDMISSATGESLLISTES,MissatgesmailingPeer::IDMISSATGE);     
     if($MODALITAT == self::ENVIATS)        $C->add( MissatgesllistesPeer::ENVIAT , null , CRITERIA::ISNOTNULL );   
     elseif($MODALITAT == self::NO_ENVIATS) $C->add( MissatgesllistesPeer::ENVIAT , null , Criteria::ISNULL );
                    
     $pager = new sfPropelPager('Missatgesmailing', 10);
	 $pager->setCriteria($C);
	 $pager->setPage($PAGINA);
	 $pager->init();  	
  	
  	 return $pager;
     
  }
  
  
  static public function EnviaMissatge($IDM,$idS)
  {

    $M = MissatgesllistesPeer::retrieveByPK($IDM);  	  
  	      	     	
    require_once('lib/vendor/swift/swift_init.php'); # needed due to symfony autoloader
  	$mailer = Swift_Mailer::newInstance(Swift_MailTransport::newInstance());
 
	$MAILS = UsuarisllistesPeer::getUsuarisLlistaEmail($M->getLlistesIdllistes()); 
	foreach($MAILS as $Email) {
     	
    	$message = Swift_Message::newInstance($M->getTitol())
        	 	->setFrom(OptionsPeer::getString('MAIL_FROM',$idS))
         		->setTo($Email)
         		->setBody($M->getText() , 'text/html');
         		  
	  	$mailer->send($message);
     	
     }
         
     $M->setEnviat(date('Y-m-d',time()));
     $M->save();
     
     return sizeof($MAILS);
  }
  

}
