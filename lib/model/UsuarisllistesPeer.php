<?php

/**
 * Subclass for performing query and update operations on the 'usuarisllistes' table.
 *
 * 
 *
 * @package lib.model
 */ 
class UsuarisllistesPeer extends BaseUsuarisllistesPeer
{

    static public function getCriteriaActiu($C,$idS)
    {
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        return $C;
    }
        
  	static public function initialize( $idUL , $idS , $idL = 0 , $idU = 0 )
	{	   
		if($idL > 0 && $idU > 0):
            $C = new Criteria();
            $C = self::getCriteriaActiu($C,$idS);
            $C->add(self::USUARIS_USUARISID, $idU);
            $C->add(self::LLISTES_IDLLISTES, $idL);
            $O = UsuarisllistesPeer::doSelectOne($C); 
        else:  
            $O = UsuarisllistesPeer::retrieveByPK($idUL);
        endif; 
        
		if(!($O instanceof UsuarisllistesPeer)):            			
			$O = new UsuarisllistesPeer();
            if( $idL > 0 ) $O->setLlistesIdllistes($idL);
            if( $idU > 0 ) $O->setUsuarisUsuarisid($idU);            
            $O->setSiteId($idS);        
            $O->setActiu(true);        						
		endif; 
        
        return new NoticiesForm($ON,array('IDS'=>$idS));
	}

  static public function Vincula( $U , $IDL )
  {     
     $ULP = new Usuarisllistes();
     $ULP->setUsuarisUsuarisid($U);
     $ULP->setLlistesIdllistes($IDL);
     $ULP->save();
  }
  
  static public function Desvincula($U , $IDL)
  {
     $C = new Criteria();
     $C->add(self::USUARIS_USUARISID , $U);
     $C->add(self::LLISTES_IDLLISTES , $IDL);     
     foreach(self::doSelect($C) as $ULP) $ULP->delete();     
  }
   
  static private function CercaUsuaris($CERCA = "")
  {
    $C = new Criteria();
    if(empty($CERCA)) return $C;
    
    foreach(explode(" ", $CERCA) as $P):
      $P = trim($P);
                  
      $C1 = $C->getNewCriterion(UsuarisPeer::DNI, "%$P%", CRITERIA::LIKE);
      $C1->addOr($C->getNewCriterion(UsuarisPeer::NOM, "%$P%", CRITERIA::LIKE));
      $C1->addOr($C->getNewCriterion(UsuarisPeer::COG1, "%$P%", CRITERIA::LIKE));
      $C1->addOr($C->getNewCriterion(UsuarisPeer::COG2, "%$P%", CRITERIA::LIKE));                  
      $C->addAnd($C1);     
      
    endforeach;
    return $C;
  } 
   
   
  static public function getVinculatsArray($IDL, $CERCA)
  {
     $C = self::CercaUsuaris($CERCA);     
     $C->add(UsuarisllistesPeer::LLISTES_IDLLISTES , $IDL);     
     $C->addJoin(UsuarisllistesPeer::USUARIS_USUARISID , UsuarisPeer::USUARIID);
     $C->addAscendingOrderByColumn(UsuarisPeer::COG1);
     $C->addAscendingOrderByColumn(UsuarisPeer::COG2);
     $C->addAscendingOrderByColumn(UsuarisPeer::NOM);
     
     $RET = array();
     
     foreach(UsuarisPeer::doSelect($C) as $OU):
        $RET[$OU->getUsuariid()] = $OU->getNomComplet();
     endforeach;
     
     return $RET;

  }
  
  static public function getDesvinculatsArray($IDL, $CERCA)
  {
    
  	 $SQL = "UsuariID not in (SELECT Usuaris_UsuarisID FROM usuarisllistes where Llistes_idLlistes = $IDL) ";
    	
  	 $C = self::CercaUsuaris($CERCA);     
     $C->add(UsuarisPeer::USUARIID, $SQL , Criteria::CUSTOM);
     $C->addAscendingOrderByColumn(UsuarisPeer::COG1);
     $C->addAscendingOrderByColumn(UsuarisPeer::COG2);
     $C->addAscendingOrderByColumn(UsuarisPeer::NOM);
          
     $RET = array();
     
     foreach(UsuarisPeer::doSelect($C) as $OU):
        $RET[$OU->getUsuariid()] = $OU->getNomComplet();
     endforeach;
     
     return $RET;
    
  }  
  
  static public function getUsuarisLlistaEmail($idL)
  {
     
     $C = new Criteria(); $RET = array();
     $C->add(UsuarisllistesPeer::LLISTES_IDLLISTES , $idL);
     foreach(UsuarisllistesPeer::doSelect($C) as $UL):
        $email = $UL->getUsuaris()->getEmail();           
        if(self::comprobar_email($email)) $RET[] = $email;
     endforeach;

     return $RET;
  }
  
  static public function getLlistesUsuari( $idU  , $idS ){
     
     $C = new Criteria();
     $C = self::getCriteriaActiu( $C , $idS );
     $C->add(UsuarisllistesPeer::USUARIS_USUARISID , $idU);
     
     $SELECT = array();
     foreach(self::doSelect($C) as $L):        
        $SELECT[$L->getLlistesIdllistes()] = $L->getLlistes()->getNom(); 
     endforeach;
          
     return $SELECT;
  }  
  
  static public function saveUsuarisLlistes($LLISTA = array() , $idU = 0)
  {

     $C = new Criteria();
     $C->add( self::USUARIS_USUARISID , $idU );
     
     //Finalment esborrem totes les files antigues
     foreach(self::doSelect($C) as $L) $L->delete();      
     
     //Entrem les noves dades
     if(isset($LLISTA)):
	     foreach($LLISTA as $V):        
	        $L = new Usuarisllistes(); $L->setNew(true);        
	        $L->setUsuarisUsuarisid($idU);
	        $L->setLlistesIdllistes($V);     
	        $L->save();
	     endforeach;
	 endif;     
  }
  
  
  static private function comprobar_email($email){
    $mail_correcto = 0;
    //compruebo unas cosas primeras
    if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
       if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
          //miro si tiene caracter .
          if (substr_count($email,".")>= 1){
             //obtengo la terminacion del dominio
             $term_dom = substr(strrchr ($email, '.'),1);
             //compruebo que la terminación del dominio sea correcta
             if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
                //compruebo que lo de antes del dominio sea correcto
                $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
                $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
                if ($caracter_ult != "@" && $caracter_ult != "."){
                   $mail_correcto = 1;
                }
             }
          }
       }
    }
    if ($mail_correcto)
       return 1;
    else
       return 0;
} 
  
}
