<?php

/**
 * Subclass for performing query and update operations on the 'usuaris' table.
 *
 * 
 *
 * @package lib.model
 */ 
class UsuarisPeer extends BaseUsuarisPeer
{

  const ADMIN = 1;
  const REGISTERED = 2;  
  
  static public function initialize( $idU , $idS , $isMatricules = false , $isWeb = false )
  {
    $OU = UsuarisPeer::retrieveByPK($idU);            
	if(!($OU instanceof Usuaris)):            		
		$OU = new Usuaris();
        $OU->setSiteId($idS);        
        $OU->setActiu(true);
		$OU->setNivellsIdnivells(NivellsPeer::REGISTRAT);
    	$OU->setHabilitat(true);     
	endif; 

    if($isMatricules):
        return new UsuarisMatriculesForm($OU);
    elseif($isWeb):
        return new ClientUsuarisForm($OU);
    else:
        return new UsuarisForm($OU);
    endif; 			    

  }
  
  //Comprovem que l'usuari pertanyi a un SITE
  static public function getCriteriaActiu( $C , $idS = null , $nomes_actius = true )
  {        
    if($nomes_actius) $C->add(self::ACTIU, true);
    if(!is_null($idS)):
        $C->addJoin(UsuarisSitesPeer::USUARI_ID, self::USUARIID);
        $C->add(UsuarisSitesPeer::SITE_ID, $idS);
    endif; 
    
    return $C;
  }
     
  static function cercaDNI($DNI)
  {
    $C = new Criteria();                 
    $C->add(self::DNI, $DNI, Criteria::EQUAL);
    return self::doSelectOne($C);
  }
  
  static function hasDNI($DNI)
  {
    $C = new Criteria();    
    $C->add( self::DNI , $DNI , Criteria::EQUAL );
    return ( self::doCount($C) > 0 ); 
  }
    
  
  static function cercaTotsCamps( $text , $PAGINA = 1 , $idS )
  {
    $C = new Criteria();
    $C = self::CriteriaCerca($text,$C);
    $C = self::getCriteriaActiu( $C , $idS );
            
    $pager = new sfPropelPager('Usuaris', 10);
    $pager->setCriteria($C);
    $pager->setPage($PAGINA);
    $pager->init();
       
    return $pager;
     
  }
  
  
  static function cercaTotsCampsSelect($text,$limit,$idS)
  {
        
    $RET = array(); 
    $C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);
    $C = self::CriteriaCerca($text,$C);        
    $C->setLimit($limit);

    foreach(self::doSelect($C) as $U):
  		$RET[$U->getUsuariid()] = array('clau'=>$U->getUsuariid(),'text'=>$U->getDni().' - '.$U->getNomComplet());  		
  	endforeach;
       
    return $RET;
     
  }
  
  static function CriteriaCerca($text,$C)
  {
  	
  	foreach(explode(' ',$text) as $PARAULA):                
	    $C1  = $C->getNewCriterion(self::DNI, '%'.$PARAULA.'%', Criteria::LIKE);
	    $C2  = $C->getNewCriterion(self::NOM, '%'.$PARAULA.'%', Criteria::LIKE);
	    $C3  = $C->getNewCriterion(self::COG1, '%'.$PARAULA.'%', Criteria::LIKE);
	    $C4  = $C->getNewCriterion(self::COG2, '%'.$PARAULA.'%', Criteria::LIKE);
	    $C5  = $C->getNewCriterion(self::EMAIL, '%'.$PARAULA.'%', Criteria::LIKE);
	    $C6  = $C->getNewCriterion(self::ADRECA, '%'.$PARAULA.'%', Criteria::LIKE);
	    $C7  = $C->getNewCriterion(self::POBLACIO, '%'.$PARAULA.'%', Criteria::LIKE);
	    $C8  = $C->getNewCriterion(self::TELEFON, '%'.$PARAULA.'%', Criteria::LIKE);
	    $C9  = $C->getNewCriterion(self::MOBIL, '%'.$PARAULA.'%', Criteria::LIKE);
	    $C10 = $C->getNewCriterion(self::ENTITAT, '%'.$PARAULA.'%', Criteria::LIKE);    
	    $C1->addOr($C2);  $C1->addOr($C3); $C1->addOr($C4); $C1->addOr($C5);
	    $C1->addOr($C6);  $C1->addOr($C7); $C1->addOr($C8); $C1->addOr($C9);
	    $C1->addOr($C10); $C->addAnd($C1);        
    endforeach;

    return $C;
    
  }
    
  static function selectTreballadors($idS)
  {
    $C = new Criteria();
    $C = self::getCriteriaActiu($C,$idS);            
    $C->add( UsuarisSitesPeer::NIVELL_ID , NivellsPeer::ADMIN );    
    $C->addAscendingOrderByColumn(UsuarisPeer::COG1);
    $C->addAscendingOrderByColumn(UsuarisPeer::COG2);
    $C->addAscendingOrderByColumn(UsuarisPeer::NOM);    
    $TREB = self::doSelect($C);
    $RET = array();

    foreach($TREB as $T):
      
      $RET[$T->getUsuariid()] = $T->getNom()." ".$T->getCog1();    
    
    endforeach;
  
    return $RET;
  
  }
  
  static function selectAllUsers()
  {
    
    $C = new Criteria();        
    
    $C->addAscendingOrderByColumn(self::COG1);
    $C->addAscendingOrderByColumn(self::NOM);
    $C->add(self::HABILITAT , true);
    $C->add(self::ACTIU, true);
    
    $TREB = self::doSelect($C);
    $RET = array();

    foreach($TREB as $T):
      
      $RET[$T->getUsuariid()] = strtoupper(self::uc_latin1($T->getNomComplet()));    
    
    endforeach;
  
    return $RET;
    
    
  }

  static function selectUsuaris($idS,$nomes_actius = true)
  {
    $C = new Criteria();   
     
    $C = self::getCriteriaActiu($C,$idS,$nomes_actius);
    
    $C->addAscendingOrderByColumn(UsuarisPeer::COG1);
//    $C->addAscendingOrderByColumn(UsuarisPeer::COG2);
    $C->addAscendingOrderByColumn(UsuarisPeer::NOM);
    $C->add(UsuarisPeer::HABILITAT , true);
    
    $TREB = self::doSelect($C);
    $RET = array();

    foreach($TREB as $T):
      
      $RET[$T->getUsuariid()] = strtoupper(self::uc_latin1($T->getNomComplet())).' - '.$T->getDni();    
    
    endforeach;
  
    return $RET;
  
  }
 

  static function uc_latin1($str)
  {
  	$LATIN1_UC_CHARS = "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝ";
    $LATIN1_LC_CHARS = "àáâãäåæçèéêëìíîïðñòóôõöøùúûüý";
    
	$str = strtoupper(strtr($str, $LATIN1_LC_CHARS, $LATIN1_UC_CHARS));
	return strtr($str, array("ß" => "SS"));
	    
  }  
  
  static function getUserLogin($login,$password,$idS)
  {
  	
	$C = new Criteria();    
    $C = self::getCriteriaActiu($C,$idS);
    
	$C->add(self::DNI , $login );
	$C->add(self::PASSWD, $password);        

	return self::doSelectOne($C);       
  }
  
  static function isLogined($user,$pass = "")
  {
  	
  	$C = new Criteria();
  	$C->add(self::DNI , $user);
  	$C->add(self::PASSWD , $pass );
  	
  	return (self::doCount($C) == 1);
  	
  }
  
  static public function getNom($idU)
  {
  	return UsuarisPeer::retrieveByPK($idU)->getNomComplet();
  }
   
  static public function canSeeComptabilitat($idU)
  {
  	$usuaris = array(1,2,4,6,9,11,24);
  	return (in_array($idU,$usuaris)); 
  }        

  /**
   * Vincula un usuari a un Site si no existeix.
   * @param $idU Usuari ID
   * @param $idS Site ID    
   * */    
  static public function addSite($idU,$idS)
  {
    UsuarisSitesPeer::initialize($idU,$idS,false)->getObject()->save();    
  }
  
  static public function getNomAjax($idU)
  {    
    $C = new Criteria();
    $C->add(self::USUARIID, $idU);
    $OU = self::doSelectOne($C);
    if($OU instanceof Usuaris) return $OU->getDni().' - '.$OU->getNomComplet();
    else return 'n/d';
  }
    
  static public function getNomComplet($idU)
  {
    $OU = self::retrieveByPK($idU);
    if($OU instanceof Usuaris) return $OU->getNomComplet();
    else return 'n/d';
  }
  
  static public function getUserFromFacebook($fb_id){
    $C = new Criteria();
    if($fb_id > 0):
        $C->add(UsuarisPeer::FACEBOOK_ID, $fb_id);
        return self::doSelectOne($C);
    else: 
        return null;
    endif;
  }
  
  /**
   * Retorna el codi de facebook de l'usuari 
   * */
  static public function getUserFbCode($idU){
    $OU = self::retrieveByPK($idU);
    $FBi = $OU->getFacebookId();
    if(!is_null($FBi) && is_numeric($FBi)) return $FBi;
    else return 0;
    
  }

  /**
   * Aquesta funció retorna un array amb els mails dels administradors i el seu nom
   * @return Array('mail'=>nom)
   * */
  static public function getAdminMails()
  {
    
    $RET = array();
    $C = new Criteria();
    $C = self::getCriteriaActiu($C,null,true);
    $C = UsuarisSitesPeer::getCriteriaActiu($C);
    $C->addJoin(UsuarisSitesPeer::USUARI_ID, self::USUARIID);
    $C->add(UsuarisSitesPeer::NIVELL_ID, NivellsPeer::ADMIN);
    $C->addGroupByColumn(UsuarisPeer::EMAIL);
    foreach(self::doSelect($C) as $OU):
        $RET[$OU->getEmail()] = $OU->getEmail();
    endforeach;            
    
    return $RET;
    
  }
  
}
