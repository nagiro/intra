<?php

class myUser extends sfBasicSecurityUser
{
	
  /**
   * myUser::ParReqSesForm()
   * 
   * Comprova els paràmetres del request i l'actualtiza amb la sessió.
   * Si existeix al request, el guarda en sessió i el retorna.
   * Si no existeix al request, retorna el de sessió. 
   * Si tampoc existeix a la sessió retorna el default.  
   * 
   * @param mixed $request
   * @param mixed $nomCamp
   * @param mixed $default
   * @return
   */
  public function ParReqSesForm($request,$nomCamp,$default)
  {
  	  	
  	$A = $this->getAttribute('sessio',array());
            	
  	if($request->hasParameter($nomCamp)):
  		$par = $request->getParameter($nomCamp);
  	  	$A[$nomCamp] = $par;        
  	elseif(!isset($A[$nomCamp])):    
  	 	$A[$nomCamp] = $default;          		  		  		
  	endif;
               		
    $A[$nomCamp] = ($A[$nomCamp] == 'images')?$default:$A[$nomCamp];                       
                       		  	
  	$this->setAttribute('sessio',$A);  	  	  	  	  	 
               	  	    
  	return $A[$nomCamp];  	  	
  	
  }
  
  /**
   * myUser::setSessionPar()
   *
   * Actualitza un paràmetre de la sessió
   *  
   * @param mixed $nomCamp
   * @param mixed $value
   * @return
   */
  public function setSessionPar($nomCamp,$value)
  {
  	
  	$A = $this->getAttribute('sessio');  	
  	$A[$nomCamp] = $value;  	  	
  	$this->setAttribute('sessio',$A);
  	
  	return $value;
  	
  }
  
  /**
   * myUser::getSessionPar()
   * 
   * Carrega un paràmetre de la sessió 
   * 
   * @param mixed $nomCamp
   * @param string $default
   * @return
   */
  public function getSessionPar($nomCamp,$default = "")
  {
  	
  	$A = $this->getAttribute('sessio',array());
  	if(isset($A[$nomCamp])){ $NOM = $A[$nomCamp]; if($NOM == 'images') $NOM = $default; return $NOM; }
  	else return $default;
  	
  }

  /**
   * myUser::addLogAction()
   * 
   * Afegeix un registre al log amb alguna acció. Versió no estàtica. .
   * 
   * @param mixed $accio
   * @param mixed $model
   * @param mixed $dadesBefore
   * @param mixed $dadesAfter
   * @return void
   */
  public function addLogAction($accio,$model,$dadesBefore = null ,$dadesAfter = null)
  {        
    return self::addLogActionStatic($this->getSessionPar('idU'),$accio,$model,$dadesBefore,$dadesAfter);      	
  }  

  /**
   * myUser::addLogAction()
   * 
   * Afegeix un registre al log amb alguna acció.
   * 
   * @param mixed $accio
   * @param mixed $model
   * @param mixed $dadesBefore
   * @param mixed $dadesAfter
   * @return void
   */
  static public function addLogActionStatic($idU, $accio,$model,$dadesBefore = null ,$dadesAfter = null)
  {    
    
  	$time = date('Y-m-d H:i',time());
  
    $REG = "\n";
    $REG .= "<data>".$time."</data>";
    $REG .= "<usuari>".$idU."</usuari>";
    $REG .= "<accio>".$accio."</accio>";
  	$REG .= "<model>".$model."</model>";
    $REG .= "<before>".serialize($dadesBefore)."</before>";
    $REG .= "<after>".serialize($dadesAfter)."</after>";
          	  	  	  	  		  	
    file_put_contents('log.txt', $REG, FILE_APPEND);
  	
  }  



  /**
   * myUser::gestionaOrdre()
   * 
   * Funció estàtica que gestionar un ordre. 
   * Posa a la posició destí el que està a l'actual usant el mètode getOrdre()
   * 
   * @param mixed $desti
   * @param mixed $actual
   * @param mixed $idS
   * @param mixed $LO
   * @return
   */
  static public function gestionaOrdre( $desti , $actual , $idS , $LO )
  {   
     //Si el destí i actual són iguals, llavors no fem res. '
     if($desti == $actual) return null;
                                                                                  
     //Canvia l'ordre segons els intermitjos.
     foreach($LO as $O):
     
        $Ordre = $O->getOrdre();
                
        if($Ordre == $actual) $O->setOrdre($desti);                
        elseif($Ordre < $actual && $Ordre >= $desti && $actual > 0 ) $O->setOrdre($Ordre+1);
        elseif($Ordre <= $desti  && $Ordre >= $actual && $actual > 0 ) $O->setOrdre($Ordre-1);
        elseif($actual == 0 && $Ordre >= $desti) $O->setOrdre($Ordre+1); //És un nou node.        
        
	    $O->save();
     
     endforeach;
  }

  /**
   * myUser::selectOrdre()
   * 
   * Retorna un menú de Select amb els ordres actuals. 
   * Si és nou a més hi ha Ordre+1 que serà el nou ordre per defecte. 
   * 
   * @param mixed $idS
   * @param mixed $LOP
   * @param bool $NOU
   * @return
   */
  static function selectOrdre( $idS , $LOP  , $NOU = false )
  {     
     $RET = array();          
     
     $last = 1; $i = 1;
     
     foreach($LOP as $OP){
       $RET[$OP->getOrdre()] = $i++;
       $last = $OP->getOrdre()+1;         
     }          
     
     //Si és nou hi afegim un número més.
     if($NOU) { $RET[$last] = $last; }
     
     return $RET;            
  }

  /**
   * myUser::resizeImage()
   * 
   * Funció estàtica que canvia la mida d'una imatge carregada amb un input file. 
   *  
   * @param mixed $x
   * @param mixed $y
   * @param mixed $BASE
   * @param mixed $imatge_actual
   * @param mixed $new_name
   * @param mixed $borrar
   * @return
   */
  static public function resizeImage($x,$y,$BASE,$imatge_actual,$new_name,$borrar)
  {	    
	if(!empty($imatge_actual) && file_exists($BASE.$imatge_actual)):          				
	  	$img = new sfImage($BASE.$imatge_actual,'image/jpg');  	
	    $img->resize($x,$y);
	    $nomf = $new_name.'.jpg';
	    $img->saveAs($BASE.$nomf);
	    if( $imatge_actual <> $new_name && $borrar ) unlink( $BASE.$imatge_actual );
        return $nomf;
    endif;
    return false;
  }
  
  /**
   * myUser::getFacebookHeaders()
   * 
   * Genera els headesr per a poder usar els botons de Like
   * 
   * @param mixed $title
   * @param mixed $url_web
   * @param mixed $url_img
   * @param mixed $site_name
   * @param mixed $facebookID
   * @return
   */
  static public function getFacebookHeaders($title, $url_web, $url_img, $site_name, $facebookID )
  {
    $RS = '';
    $RS .= '<meta property="og:title" content="'.addslashes($title).'" />';
    $RS .= '<meta property="og:type" content="activity" />';
    $RS .= '<meta property="og:url" content="'.$url_web.'" />';
    $RS .= '<meta property="og:image" content="'.$url_img.'" />';
    $RS .= '<meta property="og:site_name" content="'.addslashes($site_name).'" />';
    $RS .= '<meta property="fb:admins" content="'.$facebookID.'" />';
    return $RS;
  }
  
  static public function text2url($string)
  {                
	$string = preg_replace("`\[.*\]`U","",$string);
	$string = preg_replace('`&(amp;)?#?[a-z0-9]+;`i','-',$string);
	$string = htmlentities($string, ENT_COMPAT, 'utf-8');
	$string = preg_replace( "`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i","\\1", $string );
	$string = preg_replace( array("`[^a-z0-9]`i","`[-]+`") , "-", $string);
	return strtolower(trim($string, '-')); 
  }  
  
  
  /**
   * Genera un objecte facebook per a l'aplicatiu de la CCG
   * @return Object Facebook()
   * */
  static public function getFbObject()
  {    
    $facebook = new Facebook(array(
      'appId' => '118293361522662',
      'secret' => '186aca12e3c6d36c2a8f45c9acc8545b',
      'cookie' => true
    ));
    
    return $facebook;
  }  
  

  /**
   * Facebook Auth
   * @return array('id' = 0,'logUrl')
   * */    
  static public function f_FbAuth($logout = false , $redirect_uri = null)
  {            
    
    $RET = array( 'user' => 0 , 'logUrl' => '' );
    $A = array('redirect_uri'=>$redirect_uri);
    
    #Creem l'objecte facebook        
    $facebook = myUser::getFbObject();       
    
    # Carreguem l'usuari que tenim en sessió (0 si no existeix)
    $uid = $facebook->getUser();
    
    # Generem la url de login
    $RET['logUrl'] = $facebook->getLoginUrl($A);

    # Si l'usuari existeix en sessió, carreguem les seves dades
    if($uid){
        try {
            #Provem a veure si l'usuari existeix
            $RET['user'] = $facebook->api('/me');
          } catch (FacebookApiException $e) {}
    }     
    
    return $RET;
  
  }

}