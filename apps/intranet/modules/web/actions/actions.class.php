<?php

/**
 * web actions.
 *
 * @package    intranet
 * @subpackage web
 * @author     Albert Joh� i Mart�
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 * 
 */

class webActions extends sfActions
{

  public function executeNotfound(sfWebRequest $request)
  {
     $this->LoadWeb($request);
     $this->setTemplate('index');
     $this->ACCIO = 'notfound';         
  }

  public function gestionaNodes($NO)
  {  	
  	
	$NODES = $this->getUser()->getSessionPar('NODES',array());
	
	if(in_array($NO,$NODES)):
		unset($NODES[$NO]);
	else:
		$NODES[$NO] = $NO;
	endif;				
	
	$this->getUser()->setSessionPar('NODES',$NODES);
	return $NODES;
		
  }
	
  public function LoadWEB(sfWebRequest $request)
  {
	
  	//Carrego els banners i les fotos que mostraré
  	//Si s'entra un menú, carrego el contingut que toca segons el menú
  		//Si el menú és només títol, mostro l'estructura de directoris
  		//Si el menú té contingut, 
  			//Si el contingut és automàtic, mostro el contingut automàtic
  			//Si el contingut és manual, mostro el contingut manual
  	//Si s'entra una cerca, carrego les activitats que corresponen a la cerca i marco el calendari els dies
  	//Si s'entra un dia del calendari, cerco les activitats d'aquell dia
  	//Si no es cap, carrego les notícies de les últimes activitats...
  	        
  	$this->setLayout('layout');   	
    $this->IDS = 1;
  	$this->FOTOS = $this->getFotos();
  	$this->BANNERS = $this->getBanners();  	
	$this->MENU = NodesPeer::retornaMenu($this->IDS);	
	$this->USUARI = $this->getUser()->getSessionPar('idU',0);
	$this->SELECCIONAT = 0;	  	
	$this->LLISTAT_ACTIVITATS = array();
	$this->ACTIVITATS_CALENDARI = array();
    $this->MISSATGE = array();
	
	if($this->getUser()->isAuthenticated()){ $this->TIPUS_MENU = 'ADMIN'; } else { $this->TIPUS_MENU = 'WEB'; }
    $this->DATACAL = $this->getUser()->ParReqSesForm($request,'DATACAL',time());            
    $this->PAGINA = $this->getUser()->ParReqSesForm($request,'p',1);

    //Gestió de menús
    $idN = $request->getParameter('node',0);   	
    $this->OBERT = $this->gestionaNodes($idN);    
      	
  	$this->accio = $request->getParameter('accio');  	  	
  	
  	if($request->hasParameter('BCERCA_x') || $request->hasParameter('CERCA') || $this->accio=='c' ):    	 
    	$this->CERCA = $this->getUser()->ParReqSesForm($request,'CERCA',"");
    	$this->accio = 'c';
    else: 
    	$this->CERCA = "";
    endif;
    
    //Carreguem els dies en els que hi ha alguna activitat.     
    $this->ACTIVITATS_CALENDARI = ActivitatsPeer::getDiesAmbActivitatsMes( $this->DATACAL , $this->IDS );  	  	  	    
        
  	switch($this->accio){  		  		  		
  		//Contingut manual
  		case 'mc':
				$this->NODE = NodesPeer::selectPagina($idN);
				$this->ACCIO = 'web';								    				
  			break;
  			
  		//Contingut automàtic de cicles
  		case 'ac':
  			$this->NODE = NodesPeer::selectPagina($idN);
  			if(!$this->NODE->isNew()):
  				$cat = $this->NODE->getCategories();
				$this->LLISTAT_CICLES = ActivitatsPeer::getCiclesCategoria( $this->IDS , $cat );
	     		$this->ACCIO = 'llistatCiclesCategoria';
	     		$ACT = ActivitatsPeer::selectCategories($this->IDS, true);
	     		$this->TITOL = "Cicles i activitats a \"".$ACT[$cat].'"';
	     		$this->CAT   = $cat;	     		
	     	endif;   			  			
	     	$this->NODE = $idN;
  			break;
  			
  		//Contingut automàtic d'activitats d'un cicle
		 case 'aca':
		 		$this->CAT = $request->getParameter('cat','');
		 		$this->IDC = $request->getParameter('idc',1);
		 		$this->PAGINA = $request->getParameter('p',1);
		 		$this->NODE   = $request->getParameter('NODE',0);		 				 		
		 		
		 		$OC = CiclesPeer::retrieveByPK($this->IDC);
		 		$this->TITOL = 'Llistat d\'activitats del cicle '.$OC->getNom();
		 				 		
		 		$this->LLISTAT_ACTIVITATS = ActivitatsPeer::getActivitatsCicles( $this->IDC , $this->IDS , true , $this->PAGINA );
  				$this->ACCIO = 'llistatActivitatsCicleCategoria';	     			     			     			
	     		   			  			
  			break;

        //Consulta un cicle
         case 'cc':  			  			  				
            $this->CICLE = CiclesPeer::retrieveByPK($request->getParameter('idC'));
            $this->ACCIO = 'mostra_cicle';	     	
	     	$this->TITOL = $this->CICLE->getNom();                                     	     			     		   			  			
  			break;

        //Llistat activitats de cicle
         case 'ccact':  			  			  		
            $this->IDC = $request->getParameter('idC');     
            $this->CICLE = CiclesPeer::retrieveByPK($this->IDC);       
            $this->LLISTAT_ACTIVITATS = CiclesPeer::getActivitatsCicleList( $this->IDC , $this->IDS , true );
            $this->ACCIO = 'mostra_activitats_cicle';	     	
	     	$this->TITOL = "Activitats || ".$this->CICLE->getNom();             
                        	     			     		   			  			
  			break;
  			
  		//Cerca  			
  		case 'c':            
            if($this->CERCA == 'mensual'):
                $this->CERCA = '';
                $this->TITOL = 'ACTIVITATS DEL MES';                
            else: 
                $this->TITOL = 'ACTIVITATS TROBADES AMB LA CERCA "'.$this->CERCA.'"';            
            endif;
               			  			
  			$this->LLISTAT_ACTIVITATS = ActivitatsPeer::getActivitatsCerca( $this->CERCA , $this->DATACAL  , $this->PAGINA , $this->IDS );                                                                  						
	    	$this->ACCIO = 'llistat_activitats_cerca';	    	
	    	$this->MODE  = 'CERCA';                     		
  			break;
  			
  		//Cerca un dia
		case 'ca':						
			$this->LLISTAT_ACTIVITATS = ActivitatsPeer::getActivitatsDia( $this->IDS , date('Y-m-d',$this->DATACAL) , $this->PAGINA );			
	    	$this->ACCIO = 'llistat_activitats';
	    	$this->TITOL = 'ACTIVITATS EL DIA '.date('d/m/Y',$this->DATACAL);
	    	$this->MODE  = 'DIA';                        			
  			break;        

  		//Mostra una sola activitat
		case 'caa':
			$this->LLISTAT_ACTIVITATS = array(ActivitatsPeer::retrieveByPK($request->getParameter('idA')));
			$this->NODE = $request->getParameter('node',0);
  			$this->ACCIO = 'mostra_activitat';
  			$this->TITOL = 'Informació de l\'activitat';

            $OA = $this->LLISTAT_ACTIVITATS[0];              
            $this->getResponse()->addMeta('facebook',
                                    myUser::getFacebookHeaders( $OA->getTmig() , 
                                                                sfConfig::get('sf_webdomain').$this->getController()->genUrl('@web_activitat?idA='.$OA->getActivitatId().'&titol='.$OA->getNomForUrl()),
                                                                sfConfig::get('sf_webrooturl').'images/activitats/'.$OA->getActivitatId().'.jpg',
                                                                'Casa de Cultura de Girona',
                                                                '1763108168308'
                                                                )
                                        );                                                                	     			     			     		
			break;		
			
  		//Canvi data del calendari
		case 'cdc':				
				$this->redirect('web/index?accio=c&CERCA=mensual&DATACAL='.$this->DATACAL);							
			break;
  		//Mostrem notícies		  	
		default:
			
			$this->IDN = $request->getParameter('idN',0);
			$this->PAGINA = $request->getParameter('p',1);
			                                                                 
	   		if($this->IDN > 0):	   			
	   			$this->NOTICIA = NoticiesPeer::getNoticia($this->IDN,$this->IDS);

                $this->getResponse()->addMeta('facebook',
                    myUser::getFacebookHeaders(
                        $this->NOTICIA->getTitolnoticia(),
                        sfConfig::get('sf_webdomain').$this->getController()->genUrl('@web_noticia?idN='.$this->NOTICIA->getIdnoticia().'&p='.$this->PAGINA.'&titol='.$this->NOTICIA->getNomForUrl()),
                        sfConfig::get('sf_webrooturl').'images/noticies/'.$this->NOTICIA->getIdnoticia().'.jpg',
                        'Casa de Cultura de Girona',
                        '1763108168308'));
                                        
	   			$this->NOTICIES = null;                                                
	   		else: 	   			 
	   			$this->NOTICIA = null;
	   			$this->NOTICIES = NoticiesPeer::getNoticies('%',$this->PAGINA,true,FALSE,$this->IDS);
	   		endif; 	   	                 
	 		$this->ACCIO = 'noticies';	         	 		
	 		$this->getUser()->setSessionPar('NODES',array());	 	   				
			break;
			
			break;					  			
  	}
  	  	              
  }  
  
  
  public function executeCursos(sfWebRequest $request)
  {
     $this->LoadWeb($request);
     $this->setTemplate('index');
     $this->ACCIO = 'cursos';
     $this->CURSOS = CursosPeer::getCursos(CursosPeer::CURSACTIU,1,'',$this->IDS,true);
     
  }

  public function executeEnviaContacte(sfWebRequest $request)
  {

     $this->LoadWeb($request);
     $this->setTemplate('index');
     $this->ACCIO = 'contacte';
     $this->ENVIAT = true;
     $FConsulta = new ConsultaForm();
     $FConsulta->bind($request->getParameter('consulta'));

     $BODY = "El senyor/a {$FConsulta->getValue('Cognoms')}, {$FConsulta->getValue('Nom')}".
             " amb telèfon {$FConsulta->getValue('Telefon')} i correu electrònic {$FConsulta->getValue('Email')}".
             " vol fer el següent comentari : {$FConsulta->getValue('Missatge')} "; 
          
	  $this->sendMail('informatica@casadecultura.org','informatica@casadecultura.org',' CCG :: Formulari contacte Web ',$BODY);               
  }
  
  public function executeContacte(sfWebRequest $request)
  {
     $this->LoadWeb($request);
     $this->setTemplate('index');
     $this->ACCIO = 'contacte';
     $this->FConsulta = new ConsultaForm();     
     $this->ENVIAT = false;
  }
  
  public function executeLogout()
  {
     $this->getUser()->setAuthenticated(false);
	 $this->getUser()->setSessionPar('idU',NULL);
	 $this->redirect('web/index');
  }
/*  
  public function executeRegistre(sfWebRequest $request)
  {

     $this->LoadWEB($request);
     $this->setTemplate('index');     
     $this->ACCIO = 'registre';     
     $rand = array(1=>rand(0,10),2=>rand(0,10));
	 $this->getUser()->setSessionPar('rand',$rand);		    
	 $this->FUSUARI = new ClientUsuarisForm(new Usuaris(),array('rand'=>$rand));
     $this->ESTAT = '---'; 
  }
*/
/*  
  public function executeRegistrat(sfWebRequest $request)
  {
  	$this->LoadWEB($request);
  	
  	//Inicialitzem l'usuari per defecte.
  	$this->FUSUARI = new ClientUsuarisForm(new Usuaris(),array('rand'=>$this->getUser()->getSessionPar('rand')));  	     
    $this->FUSUARI->bind($request->getParameter('usuaris'));
  	
  	//Comprovem que el DNI no existeixi. Si ja existeix informem l'usuari
    $C = new Criteria();
    $C->add(UsuarisPeer::DNI , $this->FUSUARI->getValue('DNI'));
  	
  	$DUPLICAT = (UsuarisPeer::doCount($C) > 0);  	
  	if($this->FUSUARI->isValid() && !$DUPLICAT){
  		$this->FUSUARI->save();  		
  		$this->ESTAT = 'ALTA_OK';  		
  	} else { $this->ESTAT = "ERROR_VALID"; }  	
  	  	
 
  	 if($DUPLICAT) $this->ESTAT = 'DUPLICAT';       
     $this->setTemplate('index'); 
     $this->ACCIO = 'registre';           
     
  }
*/  
/*  
  public function executeRemember(sfWebRequest $request)
  {
  	
  	 $this->LoadWEB($request);
     $this->setTemplate('index');
	 $this->ACCIO = 'remember';
	 	 	 	  	 
	 if($request->getMethod('post') && $request->hasParameter('BREMEMBER')):
	 
	 	$this->FREMEMBER = new RememberForm(null,array('rand'=>$this->getUser()->getSessionPar('rand')));
	 	$this->FREMEMBER->bind($request->getParameter('remember'));
	 	$temp = $request->getParameter('remember');
	 	$dni = $temp['DNI'];
	 		 
	 	
    	$OUsuari = UsuarisPeer::cercaDNI($dni);
    	if($OUsuari instanceof Usuaris && $this->FREMEMBER->isValid()): 
 				    			    	
 			$BODY = "Benvolgut/da, <br /> La seva contrasenya és : <b>{$OUsuari->getPasswd()}</b>. <br /><br />Cordialment,<br /> Casa de Cultura de Girona. ";
			$this->ENVIAT = $this->sendMail('informatica@casadecultura.org',$OUsuari->getEmail(),' CCG :: Recordatori de contrasenya ',$BODY);
            $this->ENVIAT = $this->sendMail('informatica@casadecultura.org','informatica@casadecultura.org', '[CCG::RECORDATORI]',$BODY);          

		elseif($this->FREMEMBER->isValid()):
		
			$this->ERROR = "El DNI no existeix o suma incorrecte.";
			$this->ENVIAT = false; 			
			
		else:
		 
			$this->ERROR = "";
			$this->ENVIAT = false;
			 								 		 			
		endif;
					 		 
	 else:
	 
	 	//Inicialitzem el formulari
		$rand = array(1=>rand(0,10),2=>rand(0,10));
		$this->getUser()->setSessionPar('rand',$rand);		    	 	
		$this->FREMEMBER = new RememberForm(null,array('rand'=>$rand));
	 	$this->ERROR = "";
	 	$this->ENVIAT = false; 
	 endif;
         
  }
*/
/*  
  public function executeLogin(sfWebRequest $request)
  {
     $this->LoadWEB($request);
     $this->setTemplate('index');

     $this->FLogin = new LoginForm();
     $this->ERROR = "";
     
     if($request->hasParameter('form_login_remember')):
     	$this->redirect('web/remember');     
     endif;
     
     if($request->hasParameter('form_login_new')):
     	$this->redirect('web/registre');
     else:
     	$this->ACCIO = 'login';
     endif; 
     
     if($request->isMethod('POST')):
     	$L = $request->getParameter('login');     		 
     	$this->FLogin = new LoginForm();
     	$this->FLogin->bind($L);
     	if($this->FLogin->isValid()):     		 
     		 $USUARI = UsuarisPeer::getUserLogin($L['nick'], $L['password']);     		 
     		 if($USUARI instanceof Usuaris):
     		 	$this->getUser()->setSessionPar('idU',$USUARI->getUsuariid());     		 	      		
     		 	$this->getUser()->setAuthenticated(true);
    			if($USUARI->getNivellsIdnivells() == 1) { $this->getUser()->addCredential('admin'); }
     		 	if($USUARI->getNivellsIdnivells() == 2) { $this->getUser()->addCredential('user'); }

                //Carreguem el primer site de l'usuari si en pot veure
                $firstSite = UsuarisSitesPeer::getFirstSite($USUARI);
                if(is_null($firstSite)) $this->redirect('gestio/login');
                else $this->getUser()->setSessionPar('idS',$firstSite);

     		 	//Guardem un registre del login
     		 	$this->getUser()->addLogAction('login','login',$L);
     		 	
     		 	$this->redirectif( $USUARI->getNivellsIdnivells() == 1 , 'gestio/main' );
     		 	$this->redirectif( $USUARI->getNivellsIdnivells() > 1 , 'web/gestio?accio=landing');     		 	             
     		 else:     		 	
     		 	$this->getUser()->addLogAction('error','login',$L);     		 
     		 	$this->ERROR = "El DNI o la contrasenya són incorrectes";
     		 endif;
        else:
        	 $this->getUser()->addLogAction('error','login',$L);
        	 $this->ERROR = "El DNI o la contrasenya són incorrectes";
			 $this->ACCIO = 'login';
        endif;     		 
     endif;
               
  }
*/  
  
  public function executeIndex(sfWebRequest $request)
  {      
    
  	//Carrego les notícies de les últimes activitats... 
  	//Carrego els banners que mostraré
  	//Si s'entra un menú, carrego el contingut que toca segons el menú
  		//Si el menú és només títol, mostro l'estructura de directoris
  		//Si el menú té contingut, 
  			//Si el contingut és automàtic, mostro el contingut automàtic
  			//Si el contingut és manual, mostro el contingut manual
  	//Si s'entra una cerca, carrego les activitats que corresponen a la cerca i marco el calendari els dies
  	//Si s'entra un dia del calendari, cerco les activitats d'aquell dia
  	  	
    $this->LoadWEB($request);
        
  }
     
  /**
   * Funció on anem a parar si premem un boto de l'apartat de "cursos"
   * 
   */
/*  
  public function executeMatriculat(sfWebRequest $request)  
  {
     
     $this->redirectif($request->hasParameter('BNOUALUMNE'), 'web/registre' );     
     $this->redirectif($request->hasParameter('BREGISTRAT'), 'web/gestio?accio=gc');
          
  }
  
  public function executeGestio(sfWebRequest $request)
  {
    
     $this->LoadWEB($request);
     $this->setTemplate('index');
     $this->GUARDADA = false;     
     
     $accio = $this->getRequestParameter('accio');
     $this->IDU = $this->getUser()->getSessionPar('idU');
     $this->LLISTES = null;
     $this->FRESERVA = null;
     $this->RESERVES = null;
     $this->MATRICULES = null;
     $this->CURSOS = null; 
     $this->LCURSOS = array();
     $this->FUSUARI = null;
     $this->ISPLE = false;
          
     switch($accio){
	   case 'landing':
       
		    $this->MODUL = 'landing_page';
		    $this->ACCIO = 'gestio';		    		         		
     		break;
            
       case 'gd':
       
		    $this->MODUL = 'gestiona_dades';
		    $this->ACCIO = 'gestio';
		    		    
		    //Entrem la info per la gestió del captcha
		    $rand = array(1=>rand(0,10),2=>rand(0,10));
		    $this->getUser()->setSessionPar('rand',$rand);
            $OU = UsuarisPeer::initialize($this->IDU,$this->IDS,false);		    
		    $this->FUSUARI = new ClientUsuarisForm($OU->getObject(),array('rand'=>$rand));
	        break;
            
	   case 'gc':
       
	        $this->MODUL = 'gestiona_cursos';
            $this->ACCIO = 'gestio';                        
            $this->MATRICULES = MatriculesPeer::getMatriculesUsuari( $this->IDU , $this->IDS );
            $this->LCURSOS    = CursosPeer::getCursos(CursosPeer::ACTIU,1,"",$this->IDS);                                                                           
            break;
            
	   case 'gl':
       
			$this->MODUL = 'gestiona_llistes';
			$this->ACCIO = 'gestio';
			$this->LLISTES = UsuarisllistesPeer::getLlistesUsuari( $this->IDU , $this->IDS );            
			break;
            
	   case 'gr':
       
            $this->IDR = $request->getParameter('idR',0);
            $this->RESERVES = ReservaespaisPeer::getReservesUsuaris( $this->IDU , $this->IDS );            
            $this->FRESERVA = ReservaespaisPeer::initialize( $this->IDR , $this->IDS , $this->IDU , true );	   		
                           
	        $this->MODUL = 'gestiona_reserves';
	        $this->ACCIO = 'gestio';	        
	        break;
            
	   case 'sd':
       
	   		$this->MODUL = 'gestiona_dades'; $this->ACCIO = 'gestio';
            
            $RP = $request->getParameter('usuaris');                        		    
	   		$OU = UsuarisPeer::initialize($RP['UsuariID'],$this->IDS)->getObject();	   		
            $this->FUSUARI = new ClientUsuarisForm($OU,array('rand'=>$this->getUser()->getSessionPar('rand')));
	   		$this->FUSUARI->bind($RP);
	   		if($this->FUSUARI->isValid()) { $this->FUSUARI->save(); $this->MISSATGE[] = "Dades modificades correctament"; }
	   		else { $this->MISSATGE[] = 'Hi ha algun error a les dades'; }     
	        break;
                   	                    	             	        
	   case 'sl':

            $RP = $request->getParameter( 'LLISTA' );       
	        UsuarisllistesPeer::saveUsuarisLlistes( $RP , $this->IDU );
	        
            $this->MODUL = 'gestiona_llistes'; $this->ACCIO = 'gestio';
		    $this->LLISTES = UsuarisllistesPeer::getLlistesUsuari( $this->IDU , $this->IDS );
		    $this->MISSATGE[] = "Dades modificades correctament";
            
	        break;
            
	   case 'sr':
	   	
	   		$PR = $request->getParameter('reservaespais');	   			   		
            $this->FRESERVA = ReservaespaisPeer::initialize( $PR['ReservaEspaiID'] , $this->IDS , $this->IDU , true );							
			$this->FRESERVA->bind($PR);				
            if($this->FRESERVA->isValid()):                
				$this->FRESERVA->save();
                $OO = $this->FRESERVA->getObject();
                $this->sendMail('informatica@casadecultura.org','informatica@casadecultura.org','CCG :: NOVA RESERVA ESPAI',ReservaespaisPeer::sendMailNovaReserva($OO),array()); 
                $this->sendMail('informatica@casadecultura.org','ctulsa@casadecultura.org','CCG :: NOVA RESERVA ESPAI',ReservaespaisPeer::sendMailNovaReserva($OO),array());                      			                	                
                $this->MISSATGE = array('Sol·licitud enviada correctament.');				
			else:
                $this->sendMail('informatica@casadecultura.org','informatica@casadecultura.org','ERROR FORMULARI RESERVA ESPAIS',print_r($this->FRESERVA));
                $this->MISSATGE = array('Hi ha hagut algun problema enviant la sol·licitud.');
			endif;			
            
            $this->RESERVES = ReservaespaisPeer::getReservesUsuaris( $this->IDU , $this->IDS );
			$this->MODUL = 'gestiona_reserves';
	        $this->ACCIO = 'gestio';	       
	        break;

	   //Anul·la la reserva
	   case 'ar':
	   		$RE = ReservaespaisPeer::retrieveByPK($this->getUser()->getSessionPar('idR'));	   			   		
	   		if($RE instanceof Reservaespais):
	   			$RE->setEstat(ReservaespaisPeer::ANULADA);
	   			$RE->save();
	   		endif;
	   		
			//Posem les dades de càrrega del mòdul
	        $this->RESERVES = ReservaespaisPeer::getReservesUsuaris($this->getUser()->getSessionPar('idU'));
	        $this->MODUL = 'gestiona_reserves'; $this->ACCIO = 'gestio';		    	   		
	   		break;
	   		
	   case 'im':   //Iniciem la matrícula
	   		                                     	   				   		   		                         
            $D = $request->getParameter('D');                        
                                                 
            $USUARI = UsuarisPeer::retrieveByPK($this->getUser()->getSessionPar('idU'));
            
            $this->DADES_MATRICULA = array();
            $this->DADES_MATRICULA['DNI'] = $USUARI->getDni();
            $this->DADES_MATRICULA['NOM'] = $USUARI->getNomComplet();
            $this->DADES_MATRICULA['IDU'] = $this->getUser()->getSessionPar('idU');
            $this->DADES_MATRICULA['MODALITAT'] = MatriculesPeer::PAGAMENT_TARGETA;
            $this->DADES_MATRICULA['DESCOMPTE'] = $D['DESCOMPTE'];
            $this->DADES_MATRICULA['DATA'] = date('d-m-Y h:m',time());
            $this->DADES_MATRICULA['COMENTARI'] = "MATRÍCULA INTERNET";
            //Apliquem els descomptes i gratuït si ja està el grup ple
            $this->DADES_MATRICULA['PREU'] = CursosPeer::CalculaPreu($D['CURS'],$D['DESCOMPTE'],$this->IDS);
            $this->DADES_MATRICULA['CURS'] = $D['CURS'];
            $this->ISPLE = CursosPeer::isPle($D['CURS'],$this->IDS);                        
              
            //Retorna id de matrícula
            $matricules = $this->guardaMatricula($this->DADES_MATRICULA,false,0,$this->IDS); 
              
            //Carreguem el TPV
            $this->TPV = MatriculesPeer::getTPV($this->DADES_MATRICULA['PREU'] , $this->DADES_MATRICULA['NOM'] , $matricules , $this->IDS );
            $this->ACCIO = "verifica";
            $this->MODUL = "gestiona_verificacio";                                                      
	        break;
     }
               
  }

  //Guardem el TPV
  public function executeGetTPV(sfWebRequest $request)
  {
  	
  	//Si arribem aquí és perquè hem fet un pagament amb tarjeta i segur que tenim lloc.   
  	if($request->getParameter('Ds_Response') == '0000'):
  		$idM = $request->getParameter('Ds_MerchantData');
  		$OM = MatriculesPeer::retrieveByPK($idM);                
  		if($OM instanceof Matricules):                        
            if(MatriculesPeer::setMatriculaPagada($idM)):              			  			
      			$this->sendMail('informatica@casadecultura.org',
      							$OM->getUsuaris()->getEmail(),  							
      							'Matrícula Casa de Cultura de Girona',
      							MatriculesPeer::MailMatricula($OM));  			
    			$this->sendMail('informatica@casadecultura.org',
      							'informatica@casadecultura.org',
      							'Matrícula Casa de Cultura de Girona',
      							MatriculesPeer::MailMatricula($OM));  							
             else: 
      			$this->sendMail('informatica@casadecultura.org',
      							$OM->getUsuaris()->getEmail(),  							
      							'Matrícula Casa de Cultura de Girona',
      							MatriculesPeer::MailMatriculaFAIL($OM));  			
    			$this->sendMail('informatica@casadecultura.org',
      							'informatica@casadecultura.org',
      							'Matrícula Casa de Cultura de Girona',
      							MatriculesPeer::MailMatriculaFAIL($OM));                          
             endif; 
  		else:
	  		$this->sendMail('informatica@casadecultura.org',
	  						'informatica@casadecultura.org',
	  						'Matrícula cobrada i Error en objecte',
	  						'Hi ha hagut algun error en una matrícula que s\'ha cobrat i no s\'ha pogut guardar com a pagada');   			  			  			
  		endif; 
  	else: 
  		$OM->setEstat(MatriculesPeer::ERROR); //Si arriba aquí és que no ha pagat correctament
  		$OM->save();
  	endif;
  	 
  	return sfView::NONE;
  	
  } 
      
  private function guardaMatricula( $DADES_MATRICULA , $IDMATRICULA = 0 , $idS )
  {
  	
     //Quan guardem la matrícula mirem
     // Si el curs és ple, guardem Estat "En llista d'espera"
     // Si queden places, guardem en procès i quan hagi pagat se li guardarà.  
     
     $M = MatriculesPeer::initialize($IDMATRICULA,$idS,false)->getObject();
                    
     if(CursosPeer::isPle($DADES_MATRICULA['CURS'],$this->IDS)):
		$M->setEstat(MatriculesPeer::EN_ESPERA);
	 else:  
     	$M->setEstat(MatriculesPeer::EN_PROCES);
     endif;
     
     $M->setUsuarisUsuariid($DADES_MATRICULA['IDU']);
     $M->setComentari("Pagament internet");
     $M->setDatainscripcio($DADES_MATRICULA['DATA']);     
     $M->setTreduccio($DADES_MATRICULA['DESCOMPTE']);
     $M->setTpagament(MatriculesPeer::PAGAMENT_TARGETA);
     $M->setCursosIdcursos($DADES_MATRICULA['CURS']);
     $M->setPagat($DADES_MATRICULA['PREU']);     
     $M->save();
     
     return $M->getIdmatricules();
     
  }
*/        
  private function getFotos()
  {
  	$FOTOS = array();
  	srand (time());
  	while(sizeof($FOTOS) < 4):    	
		$NumAleatori = rand(1,14);
		$FOTOS[$NumAleatori] = $NumAleatori;		
	endwhile;  	
	return $FOTOS;
  }
  
  private function getBanners()
  {
  	//Inicialitzacions
  	$TEMP = array('FIX'=>array() , 'VAR'=>array()); $BANNERS = array(); $C = new Criteria();
  	   	
	//Selecció i consulta de les promocions
    $i = 0;      	  
    $LOP = PromocionsPeer::getAllPromocions($this->IDS);    	  	
  	foreach($LOP as $O):  		
		if($O->getIsfixa()):					
			$TEMP['FIX'][$O->getExtensio()]['URL'] = $O->getUrl();
			$TEMP['FIX'][$O->getExtensio()]['IMG'] = $O->getExtensio();				
            $TEMP['FIX'][$O->getExtensio()]['Nom'] = $O->getNom();
		else:
			$TEMP['VAR'][$i]['URL'] = $O->getUrl();
            $TEMP['VAR'][$i]['Nom'] = $O->getNom();
			$TEMP['VAR'][$i++]['IMG'] = $O->getExtensio();
		endif;
	endforeach;
	
	//Entrem els BANNERS FIXOS
  	foreach($TEMP['FIX'] as $K=>$T):
  		$BANNERS[$T['IMG']] = $T;  	
  	endforeach;
  		  				
  	//Entrem els BANNERS VARIABLES
	$M_VAR = sizeof($TEMP['VAR'])-1;   //Agafem la mida de l'array de variables		
	
	while(sizeof($BANNERS) < 3 && (sizeof($TEMP)) > 3):
    	srand (time());
		$NumAleatori = rand( 1 , $M_VAR );	
		$BANNERS[$TEMP['VAR'][$NumAleatori]['IMG']] = $TEMP['VAR'][$NumAleatori];		
	endwhile;	
	
	return $BANNERS;
  }
  
  public function executeEspais(sfWebRequest $request)
  {
      $this->LoadWEB($request);            
      $this->setTemplate('index');
      $this->LLISTAT_ESPAIS = EspaisPeer::getEspaisSite($this->IDS);
      $this->ACCIO = 'espais';
  }
   
   private function sendMail($from,$to,$subject,$body = "",$files = array())
   {
   	
		$swift_message = $this->getMailer()->compose($from,$to,$subject,$body);
		
		foreach($files as $F):
			$swift_message->attach(Swift_Attachment::fromPath($F['tmp_name']));
		endforeach;
		
		$swift_message->setBody($body,'text/html');
		
		return $this->getMailer()->send($swift_message);
		
   }
/*   
   public function executeFormularis(sfWebRequest $request)
   {
    
        $this->LoadWEB($request);
        $this->setTemplate('index');
        //Entren crides i es mostra una reposta en web si ha anat bé o no.        
        $PARAMETRES = Encript::Desencripta($request->getParameter('PAR'));
        $PAR = unserialize($PARAMETRES);                
        switch($PAR['formulari']){
            
            //Paràmetres [id = IDReservaEspais]
            //Només es podrà si l'estat actual és ESPERA_ACCEPTACIÓ_CONDICIONS
            case 'Reserva_Espais_Mail_Accepta_Condicions':
                    $OR = ReservaespaisPeer::retrieveByPK($PAR['id']);
                    if($OR instanceof Reservaespais && $OR->setAcceptada()):                        
                        $this->MISSATGE = '<span style="font-size:14px;">La seva reserva ha estat acceptada. </span><br /><br /><span style="font-size:14px;">Sempre que ho desitji podrà consultar les seves reserves accedint a la serva zona privada del web.</span>';
                    else:
                        $this->MISSATGE = '<span style="font-size:14px;">Hi ha hagut un error tècnic en l\'acceptació.<br />Si us plau posis en contacte amb la Casa de Cultura trucant al 972.20.20.13 o bé per correu a informatica@casadecultura.org<br />Perdoni les molèsties</span>';
                    endif;                         
                    $this->ACCIO = 'missatge';                    
                break;
                
            //Des del mail la persona no accepta i rebutja les condicions. 
            case 'Reserva_Espais_Mail_Rebutja_Condicions':
                    $OR = ReservaespaisPeer::retrieveByPK($PAR['id']);
                    if($OR instanceof Reservaespais && $OR->setRebutjada()):
                        
                        $this->MISSATGE = '<span style="font-size:14px;">La seva reserva ha estat anul·lada degut a què vostè no ha acceptat les condicions de la Casa de Cultura. <br />Sempre que ho desitji podrà consultar les seves reserves accedint a la serva zona privada del web.</span">';
                    else:
                        $this->MISSATGE = '<span style="font-size:14px;">Hi ha hagut un error en l\'anul·lació de la reserva. Si us plau posis en contacte amb la Casa de Cultura trucant al 972.20.20.13 o bé per correu a informatica@casadecultura.org<br />Perdoni les molèsties</span>';
                    endif;                         
                    $this->ACCIO = 'missatge';                    
                break;                
            default:
                    
                break;
        }    
   }
 */  
}
